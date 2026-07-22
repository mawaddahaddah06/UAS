<div class="list-group list-group-flush">
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-barcode me-2'></i>Kode Supplier</div>
            <div class="col-8 fw-semibold"><span class="badge bg-secondary fs-6">{{ $supplier->code }}</span></div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-building-house me-2'></i>Nama Supplier</div>
            <div class="col-8 fw-semibold">{{ $supplier->name }}</div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-envelope me-2'></i>Email</div>
            <div class="col-8">{{ $supplier->email ?? '-' }}</div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-phone me-2'></i>Telepon</div>
            <div class="col-8">{{ $supplier->phone ?? '-' }}</div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-map me-2'></i>Alamat</div>
            <div class="col-8">{{ $supplier->address ?? '-' }}</div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-calendar me-2'></i>Dibuat Pada</div>
            <div class="col-8">{{ $supplier->created_at->format('d M Y, H:i') }}</div>
        </div>
    </div>
</div>
