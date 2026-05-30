@extends('layouts.app')

@section('title', 'Detail Tahun Ajaran')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detail Tahun Ajaran</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('master-data.tahun-ajaran.index') }}">Tahun Ajaran</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Tahun Ajaran</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 40%">Tahun Ajaran</th>
                                <td>{{ $tahunAjaran->nama }}</td>
                            </tr>
                            <tr>
                                <th>Semester</th>
                                <td>{{ $tahunAjaran->semester }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Mulai</th>
                                <td>{{ $tahunAjaran->tanggal_mulai ? $tahunAjaran->tanggal_mulai->format('d/m/Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Selesai</th>
                                <td>{{ $tahunAjaran->tanggal_selesai ? $tahunAjaran->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{!! $tahunAjaran->status_badge !!}</td>
                            </tr>
                            <tr>
                                <th>Dibuat</th>
                                <td>{{ $tahunAjaran->created_at ? $tahunAjaran->created_at->format('d/m/Y H:i') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Diperbarui</th>
                                <td>{{ $tahunAjaran->updated_at ? $tahunAjaran->updated_at->format('d/m/Y H:i') : '-' }}</td>
                            </tr>
                        </table>
                        
                        <div class="mt-3">
                            <a href="{{ route('master-data.tahun-ajaran.edit', $tahunAjaran->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil me-2"></i> Edit
                            </a>
                            <a href="{{ route('master-data.tahun-ajaran.index') }}" class="btn btn-secondary">
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
                                <span class="info-box-number">{{ $tahunAjaran->kelas->count() }}</span>
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
                        
                        @if($tahunAjaran->is_aktif)
                        <div class="alert alert-success mt-3">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Ini adalah tahun ajaran yang sedang aktif.
                        </div>
                        @endif
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
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Jurusan</th>
                                    <th>Wali Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tahunAjaran->kelas as $index => $kelas)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $kelas->nama_kelas }}</td>
                                    <td>{{ $kelas->jurusan->nama_jurusan ?? '-' }}</td>
                                    <td>{{ $kelas->waliKelas->nama_lengkap ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada kelas</td>
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