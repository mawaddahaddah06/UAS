<div class="list-group list-group-flush">
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-barcode me-2'></i>Kode Kategori</div>
            <div class="col-8 fw-semibold"><span class="badge bg-secondary fs-6">{{ $category->code }}</span></div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-purchase-tag me-2'></i>Nama Kategori</div>
            <div class="col-8 fw-semibold">{{ $category->name }}</div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-detail me-2'></i>Deskripsi</div>
            <div class="col-8">{{ $category->description ?? '-' }}</div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-calendar me-2'></i>Dibuat Pada</div>
            <div class="col-8">{{ $category->created_at->format('d M Y, H:i') }}</div>
        </div>
    </div>
</div>
