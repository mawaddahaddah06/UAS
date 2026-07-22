<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('warehouse.store') }}" method="post" class="form">
            @csrf

            <div class="mb-3">
                <label for="code" class="form-label required">Kode Gudang</label>
                <input class="form-control @error('code') is-invalid @enderror" type="text" id="code"
                    name="code" required value="{{ old('code') }}" placeholder="Contoh: WH-MAIN">
                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="name" class="form-label required">Nama Gudang / Area Storage</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                    name="name" required value="{{ old('name') }}" placeholder="Contoh: Gudang Utama A">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="manager_name" class="form-label">Nama Manajer / Penanggung Jawab</label>
                <input class="form-control @error('manager_name') is-invalid @enderror" type="text" id="manager_name"
                    name="manager_name" value="{{ old('manager_name') }}" placeholder="Contoh: Budi Santoso">
                @error('manager_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Alamat / Detail Lokasi</label>
                <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                    name="address" rows="3" placeholder="Lokasi fisik gudang atau nomor rak">{{ old('address') }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-end">
                <a href="{{ route('warehouse.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</x-app>
