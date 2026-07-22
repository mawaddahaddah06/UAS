<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockInDetail;
use App\Models\StockInHeader;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    public function index()
    {
        return view('stock_in.index', [
            'title' => 'Transaksi Barang Masuk',
            'stockIns' => StockInHeader::with(['supplier', 'user', 'details.product'])->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('stock_in.create', [
            'title' => 'Input Barang Masuk',
            'suppliers' => Supplier::all(),
            'products' => Product::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'notes' => 'nullable|string',
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required|exists:products,id',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.unit_price' => 'required|numeric|min:0',
        ], [
            'transaction_date.required' => 'Tanggal transaksi wajib diisi',
            'supplier_id.required' => 'Supplier wajib dipilih',
            'details.required' => 'Minimal harus menginput 1 item barang',
            'details.*.product_id.required' => 'Barang wajib dipilih',
            'details.*.quantity.min' => 'Jumlah barang minimal 1',
        ]);

        DB::beginTransaction();

        try {
            $dateStr = date('Ymd', strtotime($request->transaction_date));
            $randomCode = strtoupper(substr(uniqid(), -4));
            $transactionCode = 'TRX-IN-' . $dateStr . '-' . $randomCode;

            $header = StockInHeader::create([
                'transaction_code' => $transactionCode,
                'transaction_date' => $request->transaction_date,
                'supplier_id' => $request->supplier_id,
                'user_id' => Auth::id() ?? 1,
                'total_amount' => 0,
                'notes' => $request->notes,
            ]);

            $totalAmount = 0;

            foreach ($request->details as $item) {
                $subtotal = $item['quantity'] * $item['unit_price'];
                $totalAmount += $subtotal;

                StockInDetail::create([
                    'stock_in_header_id' => $header->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $subtotal,
                ]);

                // Increment Product Stock
                $product = Product::findOrFail($item['product_id']);
                $product->increment('stock_quantity', $item['quantity']);
            }

            $header->update(['total_amount' => $totalAmount]);

            DB::commit();
            return to_route('stock-in.index')->withSuccess('Transaksi barang masuk berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('stock-in.create')->withError('Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function show(StockInHeader $stockIn)
    {
        $stockIn->load(['supplier', 'user', 'details.product']);
        return view('stock_in.show', [
            'title' => 'Detail Barang Masuk',
            'stockIn' => $stockIn,
        ]);
    }

    public function destroy(StockInHeader $stockIn)
    {
        DB::beginTransaction();

        try {
            // Revert Stock
            foreach ($stockIn->details as $detail) {
                $product = Product::find($detail->product_id);
                if ($product) {
                    $product->decrement('stock_quantity', $detail->quantity);
                }
            }

            $stockIn->delete();
            DB::commit();
            return to_route('stock-in.index')->withSuccess('Transaksi barang masuk berhasil dibatalkan dan stok dikembalikan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('stock-in.index')->withError('Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
