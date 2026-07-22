<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockOutDetail;
use App\Models\StockOutHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockOutController extends Controller
{
    public function index()
    {
        return view('stock_out.index', [
            'title' => 'Transaksi Barang Keluar',
            'stockOuts' => StockOutHeader::with(['user', 'details.product'])->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('stock_out.create', [
            'title' => 'Input Barang Keluar',
            'products' => Product::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'recipient_department' => 'required|string',
            'notes' => 'nullable|string',
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required|exists:products,id',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.unit_price' => 'required|numeric|min:0',
        ], [
            'transaction_date.required' => 'Tanggal transaksi wajib diisi',
            'recipient_department.required' => 'Divisi / Penerima barang wajib diisi',
            'details.required' => 'Minimal harus menginput 1 item barang',
            'details.*.product_id.required' => 'Barang wajib dipilih',
            'details.*.quantity.min' => 'Jumlah pengeluaran minimal 1',
        ]);

        DB::beginTransaction();

        try {
            // Anti-Negative Stock Guard Validation Check
            foreach ($request->details as $item) {
                $product = Product::findOrFail($item['product_id']);
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Stok tidak mencukupi untuk barang '{$product->name}'. Stok tersedia: {$product->stock_quantity} {$product->unit}, diminta pengeluaran: {$item['quantity']} {$product->unit}");
                }
            }

            $dateStr = date('Ymd', strtotime($request->transaction_date));
            $randomCode = strtoupper(substr(uniqid(), -4));
            $transactionCode = 'TRX-OUT-' . $dateStr . '-' . $randomCode;

            $header = StockOutHeader::create([
                'transaction_code' => $transactionCode,
                'transaction_date' => $request->transaction_date,
                'recipient_department' => $request->recipient_department,
                'user_id' => Auth::id() ?? 1,
                'total_amount' => 0,
                'notes' => $request->notes,
            ]);

            $totalAmount = 0;

            foreach ($request->details as $item) {
                $subtotal = $item['quantity'] * $item['unit_price'];
                $totalAmount += $subtotal;

                StockOutDetail::create([
                    'stock_out_header_id' => $header->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $subtotal,
                ]);

                // Decrement Product Stock
                $product = Product::findOrFail($item['product_id']);
                $product->decrement('stock_quantity', $item['quantity']);
            }

            $header->update(['total_amount' => $totalAmount]);

            DB::commit();
            return to_route('stock-out.index')->withSuccess('Transaksi barang keluar berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('stock-out.create')->withError('Gagal mengeluarkan barang: ' . $e->getMessage());
        }
    }

    public function show(StockOutHeader $stockOut)
    {
        $stockOut->load(['user', 'details.product']);
        return view('stock_out.show', [
            'title' => 'Detail Barang Keluar',
            'stockOut' => $stockOut,
        ]);
    }

    public function destroy(StockOutHeader $stockOut)
    {
        DB::beginTransaction();

        try {
            // Revert Stock by incrementing back
            foreach ($stockOut->details as $detail) {
                $product = Product::find($detail->product_id);
                if ($product) {
                    $product->increment('stock_quantity', $detail->quantity);
                }
            }

            $stockOut->delete();
            DB::commit();
            return to_route('stock-out.index')->withSuccess('Transaksi barang keluar berhasil dibatalkan dan stok dikembalikan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('stock-out.index')->withError('Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
