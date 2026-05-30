@extends('layouts.app')

@section('title', 'Tahun Ajaran')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Tahun Ajaran</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item active">Tahun Ajaran</li>
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
                <h3 class="card-title">Daftar Tahun Ajaran</h3>
                <div class="card-tools">
                    <a href="{{ route('master-data.tahun-ajaran.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Tambah Tahun Ajaran
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('master-data.tahun-ajaran.index') }}" class="mb-3">
                    <div class="input-group" style="width: 300px;">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Cari tahun ajaran..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Tahun Ajaran</th>
                                <th width="15%">Semester</th>
                                <th width="15%">Tanggal Mulai</th>
                                <th width="15%">Tanggal Selesai</th>
                                <th width="10%">Status</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tahunAjaran as $index => $item)
                            <tr class="{{ $item->is_aktif ? 'table-success' : '' }}">
                                <td>{{ $tahunAjaran->firstItem() + $loop->index }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->semester }}</td>
                                <td>{{ $item->tanggal_mulai ? $item->tanggal_mulai->format('d/m/Y') : '-' }}</td>
                                <td>{{ $item->tanggal_selesai ? $item->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                                <td>{!! $item->status_badge !!}</td>
                                <td>
                                    <a href="{{ route('master-data.tahun-ajaran.show', $item->id) }}" 
                                       class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('master-data.tahun-ajaran.edit', $item->id) }}" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if(!$item->is_aktif)
                                    <form action="{{ route('master-data.tahun-ajaran.activate', $item->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" 
                                                onclick="return confirm('Aktifkan tahun ajaran ini?')"
                                                title="Aktifkan">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('master-data.tahun-ajaran.destroy', $item->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Yakin ingin menghapus tahun ajaran ini?')"
                                                title="Hapus"
                                                {{ $item->is_aktif ? 'disabled' : '' }}>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="alert alert-warning mb-0">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        Tidak ada data tahun ajaran.
                                        <a href="{{ route('master-data.tahun-ajaran.create') }}" class="alert-link">
                                            Tambah tahun ajaran baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-end mt-3">
                    {{ $tahunAjaran->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection