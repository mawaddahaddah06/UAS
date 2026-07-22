<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-4">
        <form action="{{ route('stock-adjustment.store') }}" method="post" class="form">
            @csrf

            <div class="mb-3">
                <label for="product_id" class="form-label required">Pilih Barang / Produk</label>
                <select class="form-select @error('product_id') is-invalid @enderror" id="product_id"
                    name="product_id" required>
                    <option value="">Pilih Barang</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-stock="{{ $product->stock_quantity }}" data-unit="{{ $product->unit }}">
                            {{ $product->name }} (SKU: {{ $product->sku }} | Stok Sistem saat ini: {{ $product->stock_quantity }} {{ $product->unit }})
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="system_stock_display" class="form-label">Stok di Sistem Saat Ini</label>
                    <input class="form-control bg-light" type="text" id="system_stock_display" readonly value="-">
                </div>
                <div class="col-md-6">
                    <label for="actual_quantity" class="form-label required">Jumlah Stok Fisik Hasil Opname</label>
                    <input class="form-control @error('actual_quantity') is-invalid @enderror" type="number"
                        id="actual_quantity" name="actual_quantity" required min="0" value="{{ old('actual_quantity', 0) }}">
                    @error('actual_quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="reason" class="form-label required">Alasan Penyesuaian Stok</label>
                <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason"
                    rows="3" required placeholder="Contoh: Barang Rusak Kemasan, Ditemukan Selisih Opname Fisik, Hilang, dll">{{ old('reason') }}</textarea>
                @error('reason')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="alert alert-info">
                <i class="bx bx-info-circle me-1"></i> Pengajuan stok opname ini akan berstatus <strong>PENDING</strong> dan memerlukan persetujuan dari <strong>Warehouse Manager / Superadmin</strong> sebelum stok produk resmi diperbarui.
            </div>

            <div class="text-end">
                <a href="{{ route('stock-adjustment.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i>Kirim Pengajuan Opname</button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            $('#product_id').on('change', function() {
                const stock = $(this).find(':selected').data('stock');
                const unit = $(this).find(':selected').data('unit') || 'Pcs';
                if (stock !== undefined) {
                    $('#system_stock_display').val(stock + ' ' + unit);
                } else {
                    $('#system_stock_display').val('-');
                }
            });
        </script>
    @endpush
</x-app>
