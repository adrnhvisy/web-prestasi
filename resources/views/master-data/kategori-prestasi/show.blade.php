@extends('layouts.app')

@section('title', 'Detail Kategori Prestasi')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detail Kategori Prestasi</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('master-data.kategori-prestasi.index') }}">Kategori
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
                {{-- Kolom Kiri: Informasi Kategori --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Kategori</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered m-0">
                                <tr>
                                    <th style="width: 35%">Nama Kategori</th>
                                    <td><strong>{{ $kategoriPrestasi->nama_kategori }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ $kategoriPrestasi->deskripsi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Prestasi</th>
                                    <td>
                                        <span class="badge bg-success">{{ $kategoriPrestasi->prestasi->count() }}</span>
                                        jenis
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>{{ $kategoriPrestasi->created_at ? $kategoriPrestasi->created_at->format('d/m/Y H:i') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Diperbarui</th>
                                    <td>{{ $kategoriPrestasi->updated_at ? $kategoriPrestasi->updated_at->format('d/m/Y H:i') : '-' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('master-data.kategori-prestasi.edit', $kategoriPrestasi->id) }}"
                                class="btn btn-warning">
                                <i class="bi bi-pencil me-2"></i> Edit
                            </a>
                            <a href="{{ route('master-data.kategori-prestasi.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Daftar Jenis Prestasi --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Jenis Prestasi</h3>
                            <div class="card-tools">
                                <a href="{{ route('master-data.prestasi.create') }}?kategori_id={{ $kategoriPrestasi->id }}"
                                    class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-lg"></i> Tambah Prestasi
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped m-0">
                                <thead>
                                    <tr>
                                        <th style="width: 50px">No</th>
                                        <th>Nama Prestasi</th>
                                        <th>Poin</th>
                                        <th style="width: 100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kategoriPrestasi->prestasi as $index => $p)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $p->nama_prestasi }}</td>
                                            <td><span class="badge bg-success">{{ $p->point }}</span></td>
                                            <td>
                                                <a href="{{ route('master-data.prestasi.show', $p->id) }}"
                                                    class="btn btn-sm btn-info text-white">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-3">Belum ada jenis prestasi</td>
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