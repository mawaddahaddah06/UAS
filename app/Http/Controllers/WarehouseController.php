<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    public function index()
    {
        return view('warehouse.index', [
            'title' => 'Gudang / Lokasi Storage',
            'warehouses' => Warehouse::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('warehouse.create', [
            'title' => 'Tambah Gudang',
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'code' => 'required|unique:warehouses,code',
            'name' => 'required',
            'address' => 'nullable|string',
            'manager_name' => 'nullable|string',
        ], [
            'code.required' => 'Kode gudang wajib diisi',
            'code.unique' => 'Kode gudang sudah terdaftar',
            'name.required' => 'Nama gudang wajib diisi',
        ]);

        DB::beginTransaction();

        try {
            Warehouse::create($validate);
            DB::commit();
            return to_route('warehouse.index')->withSuccess('Gudang berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('warehouse.create')->withError('Gagal menambahkan gudang: ' . $e->getMessage());
        }
    }

    public function show(Warehouse $warehouse)
    {
        return view('warehouse.show', [
            'title' => 'Detail Gudang',
            'warehouse' => $warehouse,
        ]);
    }

    public function edit(Warehouse $warehouse)
    {
        return view('warehouse.edit', [
            'title' => 'Edit Gudang',
            'warehouse' => $warehouse,
        ]);
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $validate = $request->validate([
            'code' => 'required|unique:warehouses,code,' . $warehouse->id,
            'name' => 'required',
            'address' => 'nullable|string',
            'manager_name' => 'nullable|string',
        ], [
            'code.required' => 'Kode gudang wajib diisi',
            'code.unique' => 'Kode gudang sudah terdaftar',
            'name.required' => 'Nama gudang wajib diisi',
        ]);

        DB::beginTransaction();

        try {
            $warehouse->update($validate);
            DB::commit();
            return to_route('warehouse.index')->withSuccess('Gudang berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('warehouse.edit', $warehouse)->withError('Gagal mengubah gudang: ' . $e->getMessage());
        }
    }

    public function destroy(Warehouse $warehouse)
    {
        DB::beginTransaction();

        try {
            $warehouse->delete();
            DB::commit();
            return to_route('warehouse.index')->withSuccess('Gudang berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('warehouse.index')->withError('Gagal menghapus gudang: ' . $e->getMessage());
        }
    }
}
