@extends('layouts.app')

@section('title', 'Data Jurusan')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Jurusan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Jurusan</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Content -->
<div class="app-content">
    <div class="container-fluid">

        <!-- Alert messages -->
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
                <h3 class="card-title">Daftar Jurusan</h3>
                <div class="card-tools">
                    <a href="{{ route('master-data.jurusan.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Tambah Jurusan
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Form Pencarian -->
                <form method="GET" action="{{ route('master-data.jurusan.index') }}" class="mb-3">
                    <div class="input-group" style="width: 300px;">
                        <input type="text" name="search" class="form-control" placeholder="Cari jurusan..."
                            value="{{ request('search') }}">
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
                                <th width="15%">Kode</th>
                                <th width="30%">Nama Jurusan</th>
                                <th width="35%">Deskripsi</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jurusan as $j)
                            <tr>
                                <th scope="row">{{ ($jurusan->currentPage() - 1) * $jurusan->perPage() + $loop->iteration }}</th>
                                <td>{{ $j->kode_jurusan }}</td>
                                <td>{{ $j->nama_jurusan }}</td>
                                <td>{{ $j->deskripsi ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('master-data.jurusan.show', $j->id) }}"
                                        class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('master-data.jurusan.edit', $j->id) }}"
                                        class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('master-data.jurusan.destroy', $j->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus jurusan ini?')"
                                            title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $jurusan->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection