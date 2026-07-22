<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockAdjustment;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    public function index()
    {
        return view('stock_adjustment.index', [
            'title' => 'Penyesuaian Stok Opname',
            'adjustments' => StockAdjustment::with(['product', 'warehouse', 'user', 'approvedBy'])->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('stock_adjustment.create', [
            'title' => 'Input Stok Opname',
            'products' => Product::all(),
            'warehouses' => Warehouse::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'actual_quantity' => 'required|integer|min:0',
            'reason' => 'required|string',
        ], [
            'product_id.required' => 'Barang wajib dipilih',
            'actual_quantity.required' => 'Jumlah fisik hasil opname wajib diisi',
            'reason.required' => 'Alasan penyesuaian wajib diisi',
        ]);

        DB::beginTransaction();

        try {
            $product = Product::findOrFail($request->product_id);
            $systemQty = $product->stock_quantity;
            $actualQty = $request->actual_quantity;
            $diff = $actualQty - $systemQty;
            $type = $diff >= 0 ? 'ADDITION' : 'SUBTRACTION';

            $dateStr = date('Ymd');
            $randomCode = strtoupper(substr(uniqid(), -4));
            $adjustmentCode = 'ADJ-' . $dateStr . '-' . $randomCode;

            StockAdjustment::create([
                'adjustment_code' => $adjustmentCode,
                'product_id' => $product->id,
                'warehouse_id' => $product->warehouse_id,
                'user_id' => Auth::id() ?? 1,
                'system_quantity' => $systemQty,
                'actual_quantity' => $actualQty,
                'difference' => $diff,
                'type' => $type,
                'reason' => $request->reason,
                'status' => 'PENDING',
            ]);

            DB::commit();
            return to_route('stock-adjustment.index')->withSuccess('Pengajuan stok opname berhasil disimpan dan menunggu persetujuan manager');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('stock-adjustment.create')->withError('Gagal mengajukan stok opname: ' . $e->getMessage());
        }
    }

    public function show(StockAdjustment $stockAdjustment)
    {
        $stockAdjustment->load(['product', 'warehouse', 'user', 'approvedBy']);
        return view('stock_adjustment.show', [
            'title' => 'Detail Stok Opname',
            'adjustment' => $stockAdjustment,
        ]);
    }

    public function approve(StockAdjustment $stockAdjustment)
    {
        if ($stockAdjustment->status !== 'PENDING') {
            return to_route('stock-adjustment.index')->withError('Transaksi ini sudah diproses sebelumnya');
        }

        DB::beginTransaction();

        try {
            $stockAdjustment->update([
                'status' => 'APPROVED',
                'approved_by_user_id' => Auth::id() ?? 1,
            ]);

            // Apply stock adjustment directly to product physical stock & Audit Log
            $product = Product::findOrFail($stockAdjustment->product_id);
            $qtyBefore = $product->stock_quantity;
            $product->update([
                'stock_quantity' => $stockAdjustment->actual_quantity,
            ]);
            $qtyAfter = $product->stock_quantity;

            \App\Models\StockLog::create([
                'product_id' => $product->id,
                'user_id' => Auth::id() ?? 1,
                'reference_number' => $stockAdjustment->adjustment_code,
                'type' => 'ADJUSTMENT',
                'quantity_before' => $qtyBefore,
                'quantity_change' => $stockAdjustment->difference,
                'quantity_after' => $qtyAfter,
                'notes' => 'Penyesuaian Stok Opname (Reason: ' . $stockAdjustment->reason . ')',
            ]);

            DB::commit();
            return to_route('stock-adjustment.index')->withSuccess('Stok opname berhasil disetujui dan stok produk telah diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('stock-adjustment.index')->withError('Gagal menyetujui stok opname: ' . $e->getMessage());
        }
    }

    public function reject(StockAdjustment $stockAdjustment)
    {
        if ($stockAdjustment->status !== 'PENDING') {
            return to_route('stock-adjustment.index')->withError('Transaksi ini sudah diproses sebelumnya');
        }

        DB::beginTransaction();

        try {
            $stockAdjustment->update([
                'status' => 'REJECTED',
                'approved_by_user_id' => Auth::id() ?? 1,
            ]);

            DB::commit();
            return to_route('stock-adjustment.index')->withSuccess('Pengajuan stok opname telah ditolak');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('stock-adjustment.index')->withError('Gagal menolak stok opname: ' . $e->getMessage());
        }
    }

    public function destroy(StockAdjustment $stockAdjustment)
    {
        DB::beginTransaction();

        try {
            $stockAdjustment->delete();
            DB::commit();
            return to_route('stock-adjustment.index')->withSuccess('Data stok opname berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('stock-adjustment.index')->withError('Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
