<div class="p-2">
    <div class="row mb-3">
        <div class="col-6">
            <h5 class="fw-bold text-success mb-1"><i class="bx bx-receipt me-2"></i>Bukti Penerimaan Barang</h5>
            <div class="fs-6 fw-semibold text-dark">{{ $stockIn->transaction_code }}</div>
        </div>
        <div class="col-6 text-end">
            <div class="text-muted"><i class="bx bx-calendar me-1"></i>Tanggal: {{ date('d M Y', strtotime($stockIn->transaction_date)) }}</div>
            <div class="text-muted"><i class="bx bx-user me-1"></i>Petugas: {{ $stockIn->user->name ?? '-' }}</div>
        </div>
    </div>

    <div class="card bg-light p-3 mb-3 border-0">
        <div class="row">
            <div class="col-md-6">
                <small class="text-muted d-block">Pemasok / Vendor:</small>
                <strong class="fs-6 text-dark">{{ $stockIn->supplier->name ?? '-' }}</strong>
                <div>{{ $supplier->address ?? '-' }}</div>
                <div>Telepon: {{ $supplier->phone ?? '-' }}</div>
            </div>
            <div class="col-md-6 text-end">
                <small class="text-muted d-block">Catatan Transaksi:</small>
                <div>{{ $stockIn->notes ?? 'Tidak ada catatan tambahan' }}</div>
            </div>
        </div>
    </div>

    <div class="table-responsive mb-3">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>SKU</th>
                    <th>Nama Barang</th>
                    <th class="text-center">Jumlah (Qty)</th>
                    <th class="text-end">Harga Satuan (Rp)</th>
                    <th class="text-end">Subtotal (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stockIn->details as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge bg-secondary">{{ $detail->product->sku ?? '-' }}</span></td>
                        <td class="fw-semibold">{{ $detail->product->name ?? '-' }}</td>
                        <td class="text-center fw-bold">{{ $detail->quantity }} {{ $detail->product->unit ?? 'Pcs' }}</td>
                        <td class="text-end">Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                        <td class="text-end fw-semibold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-end fw-bold">TOTAL KESELURUHAN:</th>
                    <th class="text-end fw-bold text-success fs-6">Rp {{ number_format($stockIn->total_amount, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
