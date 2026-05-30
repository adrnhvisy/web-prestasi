@extends('layouts.app')

@section('title', 'Edit Tahun Ajaran')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Tahun Ajaran</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('master-data.tahun-ajaran.index') }}">Tahun Ajaran</a></li>
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
                <h3 class="card-title">Form Edit Tahun Ajaran</h3>
                <div class="card-tools">
                    <a href="{{ route('master-data.tahun-ajaran.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('master-data.tahun-ajaran.update', $tahunAjaran->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama" class="form-label">
                                    Tahun Ajaran <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" 
                                       name="nama" 
                                       value="{{ old('nama', $tahunAjaran->nama) }}" 
                                       required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="semester" class="form-label">
                                    Semester <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('semester') is-invalid @enderror" 
                                        id="semester" name="semester" required>
                                    <option value="">Pilih Semester</option>
                                    <option value="Ganjil" {{ old('semester', $tahunAjaran->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="Genap" {{ old('semester', $tahunAjaran->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" 
                                       class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                       id="tanggal_mulai" 
                                       name="tanggal_mulai" 
                                       value="{{ old('tanggal_mulai', $tahunAjaran->tanggal_mulai ? $tahunAjaran->tanggal_mulai->format('Y-m-d') : '') }}">
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" 
                                       class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                       id="tanggal_selesai" 
                                       name="tanggal_selesai" 
                                       value="{{ old('tanggal_selesai', $tahunAjaran->tanggal_selesai ? $tahunAjaran->tanggal_selesai->format('Y-m-d') : '') }}">
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_aktif" name="is_aktif" value="1" {{ old('is_aktif', $tahunAjaran->is_aktif) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_aktif">Aktifkan tahun ajaran ini</label>
                        <small class="text-muted d-block">Jika dicentang, tahun ajaran lain akan otomatis dinonaktifkan</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update
                    </button>
                    <a href="{{ route('master-data.tahun-ajaran.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection