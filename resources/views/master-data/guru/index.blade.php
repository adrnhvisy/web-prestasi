@extends('layouts.app')

@section('title', 'Data Guru')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Guru 👨‍🏫</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Guru</li>
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

        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Daftar Guru</h3>
                <div class="card-tools">
                    <a href="{{ route('master-data.guru.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Tambah Guru
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('master-data.guru.index') }}" class="mb-3">
                    <div class="input-group" style="width: 300px;">
                        <input type="text" name="search" class="form-control" placeholder="Cari guru..."
                            value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Lengkap</th>
                                <th>NIP</th>
                                <th>Mata Pelajaran</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($guru as $g)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $g->nama_lengkap }}</td>
                                <td>{{ $g->nip }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $g->mapel ?? '---' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('master-data.guru.show', $g->id) }}"
                                            class="btn btn-sm btn-info" title="Detail">
                                            <i class="bi bi-eye text-white"></i>
                                        </a>
                                        <a href="{{ route('master-data.guru.edit', $g->id) }}"
                                            class="btn btn-sm btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('master-data.guru.destroy', $g->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus data guru ini?')"
                                                title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-500 italic">
                                    Belum ada data guru yang ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $guru->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection