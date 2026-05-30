@extends('layouts.app')

@section('title', 'Edit Jenis Pelanggaran')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Jenis Pelanggaran</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('master-data.pelanggaran.index') }}">Jenis Pelanggaran</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Edit Jenis Pelanggaran</h3>
                <div class="card-tools">
                    <a href="{{ route('master-data.pelanggaran.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('master-data.pelanggaran.update', $pelanggaran->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">
                            Kategori Pelanggaran <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('kategori_id') is-invalid @enderror" 
                                id="kategori_id" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoriList as $k)
                                <option value="{{ $k->id }}" 
                                        {{ old('kategori_id', $pelanggaran->kategori_id) == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="nama_pelanggaran" class="form-label">
                            Nama Pelanggaran <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nama_pelanggaran') is-invalid @enderror" 
                               id="nama_pelanggaran" 
                               name="nama_pelanggaran" 
                               value="{{ old('nama_pelanggaran', $pelanggaran->nama_pelanggaran) }}" 
                               required>
                        @error('nama_pelanggaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="point" class="form-label">
                            Poin <span class="text-danger">*</span>
                        </label>
                        <input type="number" 
                               class="form-control @error('point') is-invalid @enderror" 
                               id="point" 
                               name="point" 
                               value="{{ old('point', $pelanggaran->point) }}" 
                               min="0" max="100"
                               required>
                        @error('point')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" 
                                  name="deskripsi" 
                                  rows="3">{{ old('deskripsi', $pelanggaran->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update
                    </button>
                    <a href="{{ route('master-data.pelanggaran.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection