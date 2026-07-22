<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('product.update', $product) }}" method="post" class="form">
            @csrf
            @method('put')

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="sku" class="form-label required">SKU / Barcode Kode Barang</label>
                    <input class="form-control @error('sku') is-invalid @enderror" type="text" id="sku"
                        name="sku" required value="{{ old('sku', $product->sku) }}">
                    @error('sku')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="name" class="form-label required">Nama Barang</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                        name="name" required value="{{ old('name', $product->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="category_id" class="form-label required">Kategori</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                        name="category_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                                {{ $category->name }} ({{ $category->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="warehouse_id" class="form-label required">Gudang Penyimpanan</label>
                    <select class="form-select @error('warehouse_id') is-invalid @enderror" id="warehouse_id"
                        name="warehouse_id" required>
                        <option value="">Pilih Gudang</option>
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" @selected(old('warehouse_id', $product->warehouse_id) == $warehouse->id)>
                                {{ $warehouse->name }} ({{ $warehouse->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('warehouse_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label for="unit" class="form-label required">Satuan / Unit</label>
                    <input class="form-control @error('unit') is-invalid @enderror" type="text" id="unit"
                        name="unit" required value="{{ old('unit', $product->unit) }}">
                    @error('unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="purchase_price" class="form-label required">Harga Beli (Rp)</label>
                    <input class="form-control @error('purchase_price') is-invalid @enderror" type="number" step="0.01" id="purchase_price"
                        name="purchase_price" required value="{{ old('purchase_price', $product->purchase_price) }}">
                    @error('purchase_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="selling_price" class="form-label required">Harga Jual (Rp)</label>
                    <input class="form-control @error('selling_price') is-invalid @enderror" type="number" step="0.01" id="selling_price"
                        name="selling_price" required value="{{ old('selling_price', $product->selling_price) }}">
                    @error('selling_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="stock_quantity" class="form-label required">Jumlah Stok saat ini</label>
                    <input class="form-control @error('stock_quantity') is-invalid @enderror" type="number" id="stock_quantity"
                        name="stock_quantity" required value="{{ old('stock_quantity', $product->stock_quantity) }}">
                    @error('stock_quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="min_stock" class="form-label required">Batas Stok Minimum (Min Stock Alert)</label>
                    <input class="form-control @error('min_stock') is-invalid @enderror" type="number" id="min_stock"
                        name="min_stock" required value="{{ old('min_stock', $product->min_stock) }}">
                    @error('min_stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi Produk</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                    name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-end">
                <a href="{{ route('product.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</x-app>
