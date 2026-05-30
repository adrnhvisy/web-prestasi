@extends('layouts.app')

@section('title', 'Detail Jenis Prestasi')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detail Jenis Prestasi</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('master-data.prestasi.index') }}">Jenis
                                Prestasi</a></li>
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
                            <h3 class="card-title">Informasi Prestasi</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 30%">Kategori</th>
                                    <td><span class="badge bg-info">{{ $prestasi->kategori->nama_kategori ?? '-' }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nama Prestasi</th>
                                    <td>{{ $prestasi->nama_prestasi }}</td>
                                </tr>
                                <tr>
                                    <th>Poin</th>
                                    <td><span class="badge bg-success">{{ $prestasi->point }}</span></td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ $prestasi->deskripsi ?? 'Tidak ada deskripsi' }}</td>
                                </tr>
                            </table>

                            <div class="mt-3">
                                <a href="{{ route('master-data.prestasi.edit', $prestasi->id) }}"
                                    class="btn btn-warning">
                                    <i class="bi bi-pencil me-2"></i> Edit
                                </a>
                                <a href="{{ route('master-data.prestasi.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Tambahan</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Dibuat pada:</strong> {{ $prestasi->created_at->format('d M Y H:i') }}</p>
                            <p><strong>Terakhir Update:</strong> {{ $prestasi->updated_at->format('d M Y H:i') }}</p>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i> Poin ini akan otomatis diakumulasikan pada rapot
                                prestasi siswa.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection