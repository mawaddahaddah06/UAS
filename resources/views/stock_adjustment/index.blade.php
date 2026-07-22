<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('stock-adjustment.create') }}" role="button">
                <i class="bx bx-plus me-1"></i>Input Penyesuaian Stok Opname
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kode Opname</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Gudang</th>
                        <th scope="col">Stok Sistem</th>
                        <th scope="col">Stok Fisik</th>
                        <th scope="col">Selisih</th>
                        <th scope="col">Status</th>
                        <th scope="col">Disetujui Oleh</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($adjustments as $adjustment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="badge bg-secondary">{{ $adjustment->adjustment_code }}</span></td>
                            <td class="fw-semibold">{{ $adjustment->product->name ?? '-' }} ({{ $adjustment->product->sku ?? '-' }})</td>
                            <td>{{ $adjustment->warehouse->name ?? '-' }}</td>
                            <td>{{ $adjustment->system_quantity }}</td>
                            <td class="fw-bold">{{ $adjustment->actual_quantity }}</td>
                            <td>
                                @if($adjustment->difference > 0)
                                    <span class="badge bg-success">+{{ $adjustment->difference }}</span>
                                @elseif($adjustment->difference < 0)
                                    <span class="badge bg-danger">{{ $adjustment->difference }}</span>
                                @else
                                    <span class="badge bg-secondary">0</span>
                                @endif
                            </td>
                            <td>
                                @if($adjustment->status === 'APPROVED')
                                    <span class="badge bg-success"><i class="bx bx-check-circle me-1"></i>Approved</span>
                                @elseif($adjustment->status === 'REJECTED')
                                    <span class="badge bg-danger"><i class="bx bx-x-circle me-1"></i>Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="bx bx-time me-1"></i>Pending</span>
                                @endif
                            </td>
                            <td>{{ $adjustment->approvedBy->name ?? '-' }}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm btn-detail"
                                    data-route="{{ route('stock-adjustment.show', $adjustment) }}">
                                    <i class='bx bx-show'></i>
                                </button>

                                @if($adjustment->status === 'PENDING' && (Auth::user()->role === 'Superadmin' || Auth::user()->role === 'Warehouse Manager'))
                                    <form action="{{ route('stock-adjustment.approve', $adjustment) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('put')
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Setujui penyesuaian stok ini?')">
                                            <i class="bx bx-check"></i> Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('stock-adjustment.reject', $adjustment) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('put')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tolak penyesuaian stok ini?')">
                                            <i class="bx bx-x"></i> Reject
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('modals')
        <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Detail Stok Opname</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-detail">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endpush

    @push('scripts')
        <script>
            $('#data-table').on('click', '.btn-detail', function() {
                Swal.fire({
                    title: 'Memuat...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                $('#modal-detail').load($(this).data('route'), function(response, status, xhr) {
                    if (status == "success") {
                        setTimeout(() => {
                            Swal.close();
                            $('#detailModal').modal('show');
                        }, 500);
                    } else {
                        Swal.fire({ title: "Error", text: "Gagal memuat data", icon: "error" });
                    }
                });
            })
        </script>
    @endpush
</x-app>
