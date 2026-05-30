@extends('layouts.app')

@section('title', 'Jenis Pelanggaran')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Jenis Pelanggaran</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item active">Jenis Pelanggaran</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Jenis Pelanggaran</h3>
                <div class="card-tools">
                    <a href="{{ route('master-data.pelanggaran.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Tambah Pelanggaran
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('master-data.pelanggaran.index') }}" class="row mb-3">
                    <div class="col-md-4">
                        <select name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoriList as $k)
                                <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Cari pelanggaran..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i> Filter
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('master-data.pelanggaran.index') }}" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-repeat"></i> Reset
                        </a>
                    </div>
                </form>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Kategori</th>
                                <th width="40%">Nama Pelanggaran</th>
                                <th width="10%">Poin</th>
                                <th width="25%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pelanggaran as $index => $item)
                            <tr>
                                <td>{{ $pelanggaran->firstItem() + $loop->index }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $item->kategori->nama_kategori ?? '-' }}</span>
                                </td>
                                <td>{{ $item->nama_pelanggaran }}</td>
                                <td>
                                    <span class="badge bg-danger">{{ $item->point }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('master-data.pelanggaran.show', $item->id) }}" 
                                       class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('master-data.pelanggaran.edit', $item->id) }}" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('master-data.pelanggaran.destroy', $item->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Yakin ingin menghapus pelanggaran {{ $item->nama_pelanggaran }}?')"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <div class="alert alert-warning mb-0">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        Tidak ada data jenis pelanggaran.
                                        <a href="{{ route('master-data.pelanggaran.create') }}" class="alert-link">
                                            Tambah pelanggaran baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-end mt-3">
                    {{ $pelanggaran->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection