<div class="list-group list-group-flush">
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-barcode me-2'></i>SKU / Barcode</div>
            <div class="col-8 fw-semibold"><span class="badge bg-dark fs-6">{{ $product->sku }}</span></div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-box me-2'></i>Nama Barang</div>
            <div class="col-8 fw-bold fs-5 text-primary">{{ $product->name }}</div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-category me-2'></i>Kategori</div>
            <div class="col-8"><span class="badge bg-secondary fs-6">{{ $product->category->name ?? '-' }}</span></div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-store me-2'></i>Gudang / Lokasi</div>
            <div class="col-8"><span class="badge bg-info text-dark fs-6">{{ $product->warehouse->name ?? '-' }}</span></div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-purchase-tag-alt me-2'></i>Harga Beli & Jual</div>
            <div class="col-8">
                <div>Beli: <strong class="text-danger">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</strong></div>
                <div>Jual: <strong class="text-success">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</strong></div>
            </div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-layer me-2'></i>Stok Real & Batas Min</div>
            <div class="col-8">
                <span class="fw-bold fs-6">{{ $product->stock_quantity }} {{ $product->unit }}</span>
                <span class="text-muted">(Min: {{ $product->min_stock }} {{ $product->unit }})</span>
                <div class="mt-1">
                    @if($product->stock_quantity <= $product->min_stock)
                        <span class="badge bg-danger"><i class="bx bx-error me-1"></i>Stok Menipis (Segera Restock)</span>
                    @else
                        <span class="badge bg-success"><i class="bx bx-check me-1"></i>Stok Aman</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-detail me-2'></i>Deskripsi</div>
            <div class="col-8">{{ $product->description ?? '-' }}</div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-calendar me-2'></i>Dibuat Pada</div>
            <div class="col-8">{{ $product->created_at->format('d M Y, H:i') }}</div>
        </div>
    </div>
</div>
