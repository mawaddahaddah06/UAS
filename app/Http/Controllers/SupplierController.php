<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index()
    {
        return view('supplier.index', [
            'title' => 'Pemasok / Supplier',
            'suppliers' => Supplier::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('supplier.create', [
            'title' => 'Tambah Supplier',
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'code' => 'required|unique:suppliers,code',
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ], [
            'code.required' => 'Kode supplier wajib diisi',
            'code.unique' => 'Kode supplier sudah terdaftar',
            'name.required' => 'Nama supplier wajib diisi',
            'email.email' => 'Format email tidak valid',
        ]);

        DB::beginTransaction();

        try {
            Supplier::create($validate);
            DB::commit();
            return to_route('supplier.index')->withSuccess('Supplier berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('supplier.create')->withError('Gagal menambahkan supplier: ' . $e->getMessage());
        }
    }

    public function show(Supplier $supplier)
    {
        return view('supplier.show', [
            'title' => 'Detail Supplier',
            'supplier' => $supplier,
        ]);
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', [
            'title' => 'Edit Supplier',
            'supplier' => $supplier,
        ]);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validate = $request->validate([
            'code' => 'required|unique:suppliers,code,' . $supplier->id,
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ], [
            'code.required' => 'Kode supplier wajib diisi',
            'code.unique' => 'Kode supplier sudah terdaftar',
            'name.required' => 'Nama supplier wajib diisi',
            'email.email' => 'Format email tidak valid',
        ]);

        DB::beginTransaction();

        try {
            $supplier->update($validate);
            DB::commit();
            return to_route('supplier.index')->withSuccess('Supplier berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('supplier.edit', $supplier)->withError('Gagal mengubah supplier: ' . $e->getMessage());
        }
    }

    public function destroy(Supplier $supplier)
    {
        DB::beginTransaction();

        try {
            $supplier->delete();
            DB::commit();
            return to_route('supplier.index')->withSuccess('Supplier berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('supplier.index')->withError('Gagal menghapus supplier: ' . $e->getMessage());
        }
    }
}
