<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('product.create') }}" role="button">
                <i class="bx bx-plus me-1"></i>Tambah Barang
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">SKU / Barcode</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Gudang</th>
                        <th scope="col">Harga Beli</th>
                        <th scope="col">Harga Jual</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Status Stok</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="badge bg-dark">{{ $product->sku }}</span></td>
                            <td class="fw-semibold text-start">{{ $product->name }}</td>
                            <td><span class="badge bg-secondary">{{ $product->category->name ?? '-' }}</span></td>
                            <td><span class="badge bg-info text-dark">{{ $product->warehouse->name ?? '-' }}</span></td>
                            <td class="text-end">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                            <td class="fw-bold fs-6">{{ $product->stock_quantity }} {{ $product->unit }}</td>
                            <td>
                                @if($product->stock_quantity <= $product->min_stock)
                                    <span class="badge bg-danger"><i class="bx bx-error me-1"></i>Stok Menipis</span>
                                @else
                                    <span class="badge bg-success"><i class="bx bx-check me-1"></i>Normal</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm btn-detail"
                                    data-route="{{ route('product.show', $product) }}">
                                    <i class='bx bx-show'></i>
                                </button>
                                <a href="{{ route('product.edit', $product) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('product.destroy', $product) }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('modals')
        <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Detail Barang</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-detail">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endpush

    @push('scripts')
        <script>
            $('#data-table').on('click', '.btn-delete', function() {
                $('#form-delete').attr('action', $(this).data('route'))
            })

            $('#data-table').on('click', '.btn-detail', function() {
                Swal.fire({
                    title: 'Memuat...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                $('#modal-detail').load($(this).data('route'), function(response, status, xhr) {
                    if (status == "success") {
                        setTimeout(() => {
                            Swal.close();
                            $('#detailModal').modal('show');
                        }, 500);
                    } else {
                        Swal.fire({ title: "Error", text: "Gagal memuat data", icon: "error" });
                    }
                });
            })
        </script>
    @endpush
</x-app>
