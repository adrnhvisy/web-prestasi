@extends('layouts.app')

@section('title', 'Detail Jurusan')

@section('content')
    <!-- Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detail Jurusan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('master-data.jurusan.index') }}">Jurusan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Jurusan</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 30%">Kode Jurusan</th>
                                    <td>{{ $jurusan->kode_jurusan }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Jurusan</th>
                                    <td>{{ $jurusan->nama_jurusan }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ $jurusan->deskripsi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>{{ $jurusan->created_at ? $jurusan->created_at->format('d/m/Y H:i') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Diperbarui</th>
                                    <td>{{ $jurusan->updated_at ? $jurusan->updated_at->format('d/m/Y H:i') : '-' }}</td>
                                </tr>
                            </table>

                            <div class="mt-3">
                                <a href="{{ route('master-data.jurusan.edit', $jurusan->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil me-2"></i> Edit
                                </a>
                                <a href="{{ route('master-data.jurusan.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Statistik</h3>
                        </div>
                        <div class="card-body">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-info"><i class="bi bi-building"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Jumlah Kelas</span>
                                    <span class="info-box-number">{{ $jurusan->kelas()->count() }}</span>
                                </div>
                            </div>

                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-primary"><i class="bi bi-people"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Siswa</span>
                                    <span class="info-box-number">0</span>
                                    <small class="text-muted">(akan dihitung dari kelas)</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Kelas</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Kelas</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Wali Kelas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jurusan->kelas as $kelas)
                                        <tr>
                                            <td>{{ $kelas->nama_kelas }}</td>
                                            <td>{{ $kelas->tahunAjaran->nama ?? '-' }}</td>
                                            <td>{{ $kelas->waliKelas->nama_lengkap ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Belum ada kelas</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection