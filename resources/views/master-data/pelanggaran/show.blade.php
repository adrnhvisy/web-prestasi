@extends('layouts.app')

@section('title', 'Detail Jenis Pelanggaran')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detail Jenis Pelanggaran</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('master-data.pelanggaran.index') }}">Jenis Pelanggaran</a></li>
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
                        <h3 class="card-title">Informasi Pelanggaran</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 30%">Kategori</th>
                                <td>
                                    <span class="badge bg-info">{{ $pelanggaran->kategori->nama_kategori ?? '-' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Nama Pelanggaran</th>
                                <td>{{ $pelanggaran->nama_pelanggaran }}</td>
                            </tr>
                            <tr>
                                <th>Poin</th>
                                <td><span class="badge bg-danger">{{ $pelanggaran->point }}</span></td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $pelanggaran->deskripsi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Dibuat</th>
                                <td>{{ $pelanggaran->created_at ? $pelanggaran->created_at->format('d/m/Y H:i') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Diperbarui</th>
                                <td>{{ $pelanggaran->updated_at ? $pelanggaran->updated_at->format('d/m/Y H:i') : '-' }}</td>
                            </tr>
                        </table>
                        
                        <div class="mt-3">
                            <a href="{{ route('master-data.pelanggaran.edit', $pelanggaran->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil me-2"></i> Edit
                            </a>
                            <a href="{{ route('master-data.pelanggaran.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Statistik Penggunaan</h3>
                    </div>
                    <div class="card-body">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-danger"><i class="bi bi-exclamation-triangle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Frekuensi Penggunaan</span>
                                <span class="info-box-number">{{ $pelanggaran->inputPelanggaran_count ?? 0 }} kali</span>
                            </div>
                        </div>
                        
                        <div class="alert alert-warning mt-3">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Catatan:</strong> Pelanggaran yang sudah digunakan tidak dapat dihapus.
                        </div>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Kategori</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Kategori:</strong> {{ $pelanggaran->kategori->nama_kategori ?? '-' }}</p>
                        <p><strong>Deskripsi Kategori:</strong> {{ $pelanggaran->kategori->deskripsi ?? '-' }}</p>
                        <a href="{{ route('master-data.kategori-pelanggaran.show', $pelanggaran->kategori_id) }}" 
                           class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i> Lihat Detail Kategori
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection