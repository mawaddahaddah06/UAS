<div class="list-group list-group-flush">
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-barcode me-2'></i>Kode Opname</div>
            <div class="col-8 fw-semibold"><span class="badge bg-secondary fs-6">{{ $adjustment->adjustment_code }}</span></div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-box me-2'></i>Barang</div>
            <div class="col-8 fw-bold fs-6 text-primary">{{ $adjustment->product->name ?? '-' }} (SKU: {{ $adjustment->product->sku ?? '-' }})</div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-store me-2'></i>Gudang</div>
            <div class="col-8">{{ $adjustment->warehouse->name ?? '-' }}</div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-layer me-2'></i>Stok Sistem vs Fisik</div>
            <div class="col-8">
                <div>Stok Sistem: <strong>{{ $adjustment->system_quantity }}</strong></div>
                <div>Stok Fisik: <strong>{{ $adjustment->actual_quantity }}</strong></div>
                <div class="mt-1">
                    Selisih: 
                    @if($adjustment->difference > 0)
                        <span class="badge bg-success fs-6">+{{ $adjustment->difference }}</span>
                    @elseif($adjustment->difference < 0)
                        <span class="badge bg-danger fs-6">{{ $adjustment->difference }}</span>
                    @else
                        <span class="badge bg-secondary fs-6">0</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-detail me-2'></i>Alasan Penyesuaian</div>
            <div class="col-8">{{ $adjustment->reason }}</div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-check-shield me-2'></i>Status & Approval</div>
            <div class="col-8">
                @if($adjustment->status === 'APPROVED')
                    <span class="badge bg-success"><i class="bx bx-check-circle me-1"></i>Approved</span>
                @elseif($adjustment->status === 'REJECTED')
                    <span class="badge bg-danger"><i class="bx bx-x-circle me-1"></i>Rejected</span>
                @else
                    <span class="badge bg-warning text-dark"><i class="bx bx-time me-1"></i>Pending</span>
                @endif
                <div class="small text-muted mt-1">Disetujui oleh: {{ $adjustment->approvedBy->name ?? 'Belum disetujui' }}</div>
            </div>
        </div>
    </div>
    <div class="list-group-item px-0 border-0">
        <div class="row">
            <div class="col-4 text-muted"><i class='bx bx-user me-2'></i>Pembuat Pengajuan</div>
            <div class="col-8">{{ $adjustment->user->name ?? '-' }}</div>
        </div>
    </div>
</div>
