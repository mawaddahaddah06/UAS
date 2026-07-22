<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index', [
            'title' => 'Master Barang / Produk',
            'products' => Product::with(['category', 'warehouse'])->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('product.create', [
            'title' => 'Tambah Barang',
            'categories' => Category::all(),
            'warehouses' => Warehouse::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'sku' => 'required|unique:products,sku',
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'unit' => 'required',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ], [
            'sku.required' => 'SKU / Barcode wajib diisi',
            'sku.unique' => 'SKU / Barcode sudah terdaftar',
            'name.required' => 'Nama barang wajib diisi',
            'category_id.required' => 'Kategori wajib dipilih',
            'warehouse_id.required' => 'Gudang lokasi wajib dipilih',
            'unit.required' => 'Satuan unit wajib diisi',
            'purchase_price.required' => 'Harga beli wajib diisi',
            'selling_price.required' => 'Harga jual wajib diisi',
            'stock_quantity.required' => 'Stok awal wajib diisi',
            'min_stock.required' => 'Stok minimum wajib diisi',
        ]);

        DB::beginTransaction();

        try {
            Product::create($validate);
            DB::commit();
            return to_route('product.index')->withSuccess('Barang berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('product.create')->withError('Gagal menambahkan barang: ' . $e->getMessage());
        }
    }

    public function show(Product $product)
    {
        $product->load(['category', 'warehouse']);
        return view('product.show', [
            'title' => 'Detail Barang',
            'product' => $product,
        ]);
    }

    public function edit(Product $product)
    {
        return view('product.edit', [
            'title' => 'Edit Barang',
            'product' => $product,
            'categories' => Category::all(),
            'warehouses' => Warehouse::all(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validate = $request->validate([
            'sku' => 'required|unique:products,sku,' . $product->id,
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'unit' => 'required',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ], [
            'sku.required' => 'SKU / Barcode wajib diisi',
            'sku.unique' => 'SKU / Barcode sudah terdaftar',
            'name.required' => 'Nama barang wajib diisi',
            'category_id.required' => 'Kategori wajib dipilih',
            'warehouse_id.required' => 'Gudang lokasi wajib dipilih',
            'unit.required' => 'Satuan unit wajib diisi',
        ]);

        DB::beginTransaction();

        try {
            $product->update($validate);
            DB::commit();
            return to_route('product.index')->withSuccess('Barang berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('product.edit', $product)->withError('Gagal mengubah barang: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();

        try {
            $product->delete();
            DB::commit();
            return to_route('product.index')->withSuccess('Barang berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('product.index')->withError('Gagal menghapus barang: ' . $e->getMessage());
        }
    }
}
