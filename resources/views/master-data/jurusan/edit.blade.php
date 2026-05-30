@extends('layouts.app')

@section('title', 'Edit Jurusan')

@section('content')
    <!-- Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Jurusan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('master-data.jurusan.index') }}">Jurusan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="app-content">
        <div class="container-fluid">

            <!-- Error messages -->
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
                    <h3 class="card-title">Form Edit Jurusan</h3>
                    <div class="card-tools">
                        <a href="{{ route('master-data.jurusan.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('master-data.jurusan.update', $jurusan->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="kode_jurusan" class="form-label">
                                Kode Jurusan <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('kode_jurusan') is-invalid @enderror"
                                id="kode_jurusan" name="kode_jurusan"
                                value="{{ old('kode_jurusan', $jurusan->kode_jurusan) }}" required maxlength="20">
                            @error('kode_jurusan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_jurusan" class="form-label">
                                Nama Jurusan <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama_jurusan') is-invalid @enderror"
                                id="nama_jurusan" name="nama_jurusan"
                                value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}" required maxlength="100">
                            @error('nama_jurusan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi"
                                name="deskripsi" rows="3">{{ old('deskripsi', $jurusan->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update
                        </button>
                        <a href="{{ route('master-data.jurusan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x"></i> Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection