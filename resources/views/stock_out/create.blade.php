<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-4">
        <form action="{{ route('stock-out.store') }}" method="post" class="form" id="form-stock-out">
            @csrf

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="transaction_date" class="form-label required">Tanggal Transaksi</label>
                    <input class="form-control @error('transaction_date') is-invalid @enderror" type="date"
                        id="transaction_date" name="transaction_date" required value="{{ old('transaction_date', date('Y-m-d')) }}">
                    @error('transaction_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="recipient_department" class="form-label required">Divisi / Peruntukan / Penerima Barang</label>
                    <input class="form-control @error('recipient_department') is-invalid @enderror" type="text"
                        id="recipient_department" name="recipient_department" required value="{{ old('recipient_department') }}"
                        placeholder="Contoh: Divisi Operasional & Produksi">
                    @error('recipient_department')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="card border mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="bx bx-list-minus me-2"></i>Daftar Item Pengeluaran Barang</h6>
                    <button type="button" class="btn btn-sm btn-success" id="btn-add-item">
                        <i class="bx bx-plus me-1"></i>Tambah Baris
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0" id="table-items">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40%;">Barang / Produk</th>
                                    <th style="width: 20%;">Jumlah Keluar (Qty)</th>
                                    <th style="width: 25%;">Harga Satuan (Rp)</th>
                                    <th style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="item-rows">
                                <tr class="item-row">
                                    <td>
                                        <select name="details[0][product_id]" class="form-select product-select" required>
                                            <option value="">Pilih Barang</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}" data-stock="{{ $product->stock_quantity }}">
                                                    {{ $product->name }} (SKU: {{ $product->sku }} | Stok Tersedia: {{ $product->stock_quantity }} {{ $product->unit }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="details[0][quantity]" class="form-control item-qty" min="1" value="1" required>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="details[0][unit_price]" class="form-control item-price" min="0" value="0" required>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm btn-remove-row"><i class="bx bx-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label for="notes" class="form-label">Catatan Transaksi</label>
                <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Catatan tujuan pengeluaran barang, project code, dll">{{ old('notes') }}</textarea>
            </div>

            <div class="text-end">
                <a href="{{ route('stock-out.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i>Simpan Transaksi Barang Keluar</button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            let rowIndex = 1;
            const productOptions = `@foreach ($products as $product)
                <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}" data-stock="{{ $product->stock_quantity }}">
                    {{ $product->name }} (SKU: {{ $product->sku }} | Stok Tersedia: {{ $product->stock_quantity }} {{ $product->unit }})
                </option>
            @endforeach`;

            $('#btn-add-item').on('click', function() {
                const newRow = `
                    <tr class="item-row">
                        <td>
                            <select name="details[${rowIndex}][product_id]" class="form-select product-select" required>
                                <option value="">Pilih Barang</option>
                                ${productOptions}
                            </select>
                        </td>
                        <td>
                            <input type="number" name="details[${rowIndex}][quantity]" class="form-control item-qty" min="1" value="1" required>
                        </td>
                        <td>
                            <input type="number" step="0.01" name="details[${rowIndex}][unit_price]" class="form-control item-price" min="0" value="0" required>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm btn-remove-row"><i class="bx bx-trash"></i></button>
                        </td>
                    </tr>
                `;
                $('#item-rows').append(newRow);
                rowIndex++;
            });

            $(document).on('click', '.btn-remove-row', function() {
                if ($('.item-row').length > 1) {
                    $(this).closest('tr').remove();
                } else {
                    Swal.fire({ title: 'Info', text: 'Minimal harus ada 1 item barang', icon: 'info' });
                }
            });

            $(document).on('change', '.product-select', function() {
                const selectedPrice = $(this).find(':selected').data('price') || 0;
                $(this).closest('tr').find('.item-price').val(selectedPrice);
            });
        </script>
    @endpush
</x-app>
