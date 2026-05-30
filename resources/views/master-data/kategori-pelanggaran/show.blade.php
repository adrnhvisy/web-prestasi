@extends('layouts.app')

@section('title', 'Detail Kategori Pelanggaran')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detail Kategori Pelanggaran</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('master-data.kategori-pelanggaran.index') }}">Kategori Pelanggaran</a></li>
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
                        <h3 class="card-title">Informasi Kategori</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 30%">Nama Kategori</th>
                                <td><strong>{{ $kategoriPelanggaran->nama_kategori }}</strong></td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $kategoriPelanggaran->deskripsi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Pelanggaran</th>
                                <td>
                                    <span class="badge bg-info">{{ $kategoriPelanggaran->pelanggaran->count() }}</span> jenis
                                </td>
                            </tr>
                            <tr>
                                <th>Dibuat</th>
                                <td>{{ $kategoriPelanggaran->created_at ? $kategoriPelanggaran->created_at->format('d/m/Y H:i') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Diperbarui</th>
                                <td>{{ $kategoriPelanggaran->updated_at ? $kategoriPelanggaran->updated_at->format('d/m/Y H:i') : '-' }}</td>
                            </tr>
                        </table>
                        
                        <div class="mt-3">
                            <a href="{{ route('master-data.kategori-pelanggaran.edit', $kategoriPelanggaran->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil me-2"></i> Edit
                            </a>
                            <a href="{{ route('master-data.kategori-pelanggaran.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Jenis Pelanggaran</h3>
                        <div class="card-tools">
                            <a href="{{ route('master-data.pelanggaran.create') }}?kategori_id={{ $kategoriPelanggaran->id }}" 
                               class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-lg"></i> Tambah Pelanggaran
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelanggaran</th>
                                    <th>Poin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kategoriPelanggaran->pelanggaran as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->nama_pelanggaran }}</td>
                                    <td><span class="badge bg-danger">{{ $p->point }}</span></td>
                                    <td>
                                        <a href="{{ route('master-data.pelanggaran.show', $p->id) }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada jenis pelanggaran</td>
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