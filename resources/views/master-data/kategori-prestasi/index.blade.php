@extends('layouts.app')

@section('title', 'Kategori Prestasi')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Kategori Prestasi</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Master Data</li>
                        <li class="breadcrumb-item active">Kategori Prestasi</li>
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

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Kategori Prestasi</h3>
                    <div class="card-tools">
                        <a href="{{ route('master-data.kategori-prestasi.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg"></i> Tambah Kategori
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('master-data.kategori-prestasi.index') }}" class="mb-3">
                        <div class="input-group" style="width: 300px;">
                            <input type="text" name="search" class="form-control" placeholder="Cari kategori..."
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
                                    <th width="25%">Nama Kategori</th>
                                    <th width="45%">Deskripsi</th>
                                    <th width="10%">Jumlah</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kategori as $item)
                                    <tr>
                                        <td>{{ ($kategori->currentPage() - 1) * $kategori->perPage() + $loop->iteration }}</td>
                                        <td><strong>{{ $item->nama_kategori }}</strong></td>
                                        <td>{{ $item->deskripsi ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-success">{{ $item->prestasi_count }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('master-data.kategori-prestasi.show', $item->id) }}"
                                                class="btn btn-sm btn-info" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('master-data.kategori-prestasi.edit', $item->id) }}"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('master-data.kategori-prestasi.destroy', $item->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus kategori {{ $item->nama_kategori }}?')"
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
                                                Tidak ada data kategori prestasi.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        {{ $kategori->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection