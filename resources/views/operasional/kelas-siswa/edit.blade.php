@extends('layouts.app')

@section('title', 'Edit Penempatan')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Penempatan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('operasional.kelas-siswa.index') }}">Kelas Siswa</a></li>
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
                <h3 class="card-title">Form Edit Penempatan</h3>
                <div class="card-tools">
                    <a href="{{ route('operasional.kelas-siswa.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <strong>Siswa:</strong> {{ $kelasSiswa->siswa->nis }} - {{ $kelasSiswa->siswa->nama_lengkap }}
                </div>
                
                <form method="POST" action="{{ route('operasional.kelas-siswa.update', $kelasSiswa->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="kelas_id" class="form-label">
                            Pilih Kelas <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('kelas_id') is-invalid @enderror" 
                                id="kelas_id" name="kelas_id" required>
                            <option value="">Pilih Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" 
                                        {{ old('kelas_id', $kelasSiswa->kelas_id) == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="tanggal_masuk" class="form-label">
                            Tanggal Masuk <span class="text-danger">*</span>
                        </label>
                        <input type="date" 
                               class="form-control @error('tanggal_masuk') is-invalid @enderror" 
                               id="tanggal_masuk" 
                               name="tanggal_masuk" 
                               value="{{ old('tanggal_masuk', $kelasSiswa->tanggal_masuk->format('Y-m-d')) }}" 
                               required>
                        @error('tanggal_masuk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
                        <input type="date" 
                               class="form-control @error('tanggal_keluar') is-invalid @enderror" 
                               id="tanggal_keluar" 
                               name="tanggal_keluar" 
                               value="{{ old('tanggal_keluar', $kelasSiswa->tanggal_keluar ? $kelasSiswa->tanggal_keluar->format('Y-m-d') : '') }}">
                        @error('tanggal_keluar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Kosongkan jika siswa masih aktif</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update
                    </button>
                    <a href="{{ route('operasional.kelas-siswa.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection