<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('stock-log.index') }}" method="get" class="row g-3 mb-4 align-items-end">
            <div class="col-md-6">
                <label for="product_id" class="form-label font-weight-bold">Filter Kartu Stok Produk</label>
                <select name="product_id" id="product_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Tampilkan Seluruh Log Mutasi --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" @selected($selectedProductId == $product->id)>
                            {{ $product->name }} (SKU: {{ $product->sku }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 text-end">
                @if($selectedProductId)
                    <a href="{{ route('stock-log.index') }}" class="btn btn-secondary me-2"><i class="bx bx-reset me-1"></i>Reset Filter</a>
                @endif
                <span class="badge bg-primary p-2 fs-6"><i class="bx bx-shield-check me-1"></i>Append-Only Audit Trail (Immutable)</span>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Waktu & Tanggal</th>
                        <th scope="col">No. Referensi</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Tipe Mutasi</th>
                        <th scope="col">Stok Awal</th>
                        <th scope="col">Perubahan (+/-)</th>
                        <th scope="col">Stok Akhir</th>
                        <th scope="col">User Executed</th>
                        <th scope="col">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><small class="text-muted">{{ date('d M Y, H:i:s', strtotime($log->created_at)) }}</small></td>
                            <td><span class="badge bg-dark">{{ $log->reference_number }}</span></td>
                            <td class="fw-semibold">{{ $log->product->name ?? '-' }}</td>
                            <td>
                                @if($log->type === 'IN')
                                    <span class="badge bg-success"><i class="bx bx-down-arrow-alt me-1"></i>MASUK</span>
                                @elseif($log->type === 'OUT')
                                    <span class="badge bg-danger"><i class="bx bx-up-arrow-alt me-1"></i>KELUAR</span>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="bx bx-adjust me-1"></i>OPNAME</span>
                                @endif
                            </td>
                            <td>{{ $log->quantity_before }}</td>
                            <td class="fw-bold">
                                @if($log->quantity_change > 0)
                                    <span class="text-success">+{{ $log->quantity_change }}</span>
                                @else
                                    <span class="text-danger">{{ $log->quantity_change }}</span>
                                @endif
                            </td>
                            <td class="fw-bold fs-6">{{ $log->quantity_after }}</td>
                            <td>{{ $log->user->name ?? '-' }}</td>
                            <td><small>{{ $log->notes ?? '-' }}</small></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>
