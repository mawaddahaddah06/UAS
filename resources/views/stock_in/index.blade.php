<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('stock-in.create') }}" role="button">
                <i class="bx bx-plus me-1"></i>Input Transaksi Barang Masuk
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kode Transaksi</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Petugas Input</th>
                        <th scope="col">Total Item</th>
                        <th scope="col">Total Nilai (Rp)</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stockIns as $stockIn)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="badge bg-success fs-6">{{ $stockIn->transaction_code }}</span></td>
                            <td>{{ date('d M Y', strtotime($stockIn->transaction_date)) }}</td>
                            <td class="fw-semibold">{{ $stockIn->supplier->name ?? '-' }}</td>
                            <td>{{ $stockIn->user->name ?? '-' }}</td>
                            <td><span class="badge bg-secondary">{{ $stockIn->details->sum('quantity') }} Item</span></td>
                            <td class="text-end fw-bold text-success">Rp {{ number_format($stockIn->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm btn-detail"
                                    data-route="{{ route('stock-in.show', $stockIn) }}">
                                    <i class='bx bx-show'></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('stock-in.destroy', $stockIn) }}">
                                    <i class='bx bx-trash'></i> Batalkan
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
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Resi / Bukti Barang Masuk</h1>
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
