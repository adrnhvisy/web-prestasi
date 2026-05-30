@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Siswa</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item active">Siswa</li>
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
                <h3 class="card-title">Daftar Siswa</h3>
                <div class="card-tools">
                    <a href="{{ route('master-data.siswa.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Tambah Siswa
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('master-data.siswa.index') }}" class="row mb-3">
                    <div class="col-md-3">
                        <select name="kelas" class="form-select">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ request('kelas') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_lengkap }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="jenis_kelamin" class="form-select">
                            <option value="">Semua JK</option>
                            <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari nama/NIS..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('master-data.siswa.index') }}" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-repeat"></i> Reset
                        </a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="12%">NIS</th>
                                <th width="25%">Nama Lengkap</th>
                                <th width="15%">Kelas</th>
                                <th width="8%">L/P</th>
                                <th width="15%">No. Telp</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa as $index => $item)
                            <tr>
                                <td>{{ $siswa->firstItem() + $loop->index }}</td>
                                <td>{{ $item->nis }}</td>
                                <td><strong>{{ $item->nama_lengkap }}</strong></td>
                                <td>{{ $item->getKelasAktif()?->nama_kelas ?? '-' }}</td>
                                <td>{{ $item->jenis_kelamin == 'L' ? 'L' : ($item->jenis_kelamin == 'P' ? 'P' : '-') }}</td>
                                <td>{{ $item->no_telp ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('master-data.siswa.show', $item->id) }}"
                                        class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('master-data.siswa.edit', $item->id) }}"
                                        class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('master-data.siswa.destroy', $item->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus siswa {{ $item->nama_lengkap }}?')"
                                            title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('master-data.siswa.reset-password', $item->id) }}"
                                        class="btn btn-sm btn-secondary"
                                        onclick="return confirm('Reset password untuk {{ $item->nama_lengkap }}?')"
                                        title="Reset Password">
                                        <i class="bi bi-key"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="alert alert-warning mb-0">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        Tidak ada data siswa.
                                        <a href="{{ route('master-data.siswa.create') }}" class="alert-link">
                                            Tambah siswa baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $siswa->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection