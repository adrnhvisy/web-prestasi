@extends('layouts.app')

@section('title', 'Tambah Jenis Prestasi')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Tambah Jenis Prestasi</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('master-data.prestasi.index') }}">Jenis Prestasi</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Tambah Jenis Prestasi</h3>
                <div class="card-tools">
                    <a href="{{ route('master-data.prestasi.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('master-data.prestasi.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">
                            Kategori Prestasi <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('kategori_id') is-invalid @enderror" 
                                id="kategori_id" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoriList as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="nama_prestasi" class="form-label">
                            Nama Prestasi <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nama_prestasi') is-invalid @enderror" 
                               id="nama_prestasi" name="nama_prestasi" 
                               value="{{ old('nama_prestasi') }}" 
                               placeholder="Contoh: Juara Kelas, Hadir 100%" required>
                        @error('nama_prestasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="point" class="form-label">Poin <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control @error('point') is-invalid @enderror" 
                               id="point" name="point" 
                               value="{{ old('point', '10') }}" min="0" max="100" required>
                        @error('point')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                    <a href="{{ route('master-data.prestasi.index') }}" class="btn btn-secondary"><i class="bi bi-x"></i> Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection