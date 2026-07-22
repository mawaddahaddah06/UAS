<div class="list-group list-group-flush">
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-barcode me-2'></i>Kode Gudang</div>
            <div class="col-8 fw-semibold"><span class="badge bg-secondary fs-6">{{ $warehouse->code }}</span></div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-store me-2'></i>Nama Gudang</div>
            <div class="col-8 fw-semibold">{{ $warehouse->name }}</div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-user me-2'></i>Manajer Gudang</div>
            <div class="col-8">{{ $warehouse->manager_name ?? '-' }}</div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-map me-2'></i>Alamat / Lokasi</div>
            <div class="col-8">{{ $warehouse->address ?? '-' }}</div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-calendar me-2'></i>Dibuat Pada</div>
            <div class="col-8">{{ $warehouse->created_at->format('d M Y, H:i') }}</div>
        </div>
    </div>
</div>
