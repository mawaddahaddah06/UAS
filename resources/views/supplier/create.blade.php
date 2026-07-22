<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('supplier.store') }}" method="post" class="form">
            @csrf

            <div class="mb-3">
                <label for="code" class="form-label required">Kode Supplier</label>
                <input class="form-control @error('code') is-invalid @enderror" type="text" id="code"
                    name="code" required value="{{ old('code') }}" placeholder="Contoh: SUP-001">
                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="name" class="form-label required">Nama Supplier</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                    name="name" required value="{{ old('name') }}" placeholder="Contoh: PT Indologistic Vendor Utama">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input class="form-control @error('email') is-invalid @enderror" type="email" id="email"
                        name="email" value="{{ old('email') }}" placeholder="supplier@example.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="phone" class="form-label">Telepon / HP</label>
                    <input class="form-control @error('phone') is-invalid @enderror" type="text" id="phone"
                        name="phone" value="{{ old('phone') }}" placeholder="021-5551234">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Alamat Lengkap</label>
                <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                    name="address" rows="3" placeholder="Alamat pabrik / kantor supplier">{{ old('address') }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-end">
                <a href="{{ route('supplier.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</x-app>
