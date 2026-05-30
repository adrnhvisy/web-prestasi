{{-- 
@extends('layouts.app')

@section('title', 'Data Prestasi Siswa')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Daftar Prestasi Siswa</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Input Prestasi</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('operasional.input-prestasi.index') }}" method="GET" class="row g-3">
<div class="col-md-4">
    <input type="text" name="search" class="form-control" placeholder="Cari Nama Siswa atau NIS..." value="{{ request('search') }}">
</div>
<div class="col-md-3">
    <select name="kelas_id" class="form-select">
        <option value="">-- Semua Kelas --</option>
        @foreach($filterKelas as $k)
        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
        @endforeach
    </select>
</div>
<div class="col-md-3">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-search me-1"></i> Filter
    </button>
    <a href="{{ route('operasional.input-prestasi.index') }}" class="btn btn-secondary">Reset</a>
</div>
<div class="col-md-2 text-end">
    <a href="{{ route('operasional.input-prestasi.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Input Baru
    </a>
</div>
</form>
</div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Riwayat Prestasi Terbaru</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Kode</th>
                        <th>Waktu</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Jenis Prestasi</th>
                        <th>Poin/Bobot</th>
                        <th>Guru</th>
                        <th style="width: 150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestasi as $item)
                    <tr>
                        <td>{{ ($prestasi->currentPage() - 1) * $prestasi->perPage() + $loop->iteration }}</td>
                        <td><code>{{ $item->kode_transaksi }}</code></td>
                        <td>{{ $item->waktu->format('d/m/Y H:i') }}</td>
                        <td>
                            <strong>{{ $item->siswa->nama_lengkap }}</strong><br>
                            <small class="text-muted">NIS: {{ $item->siswa->nis }}</small>
                        </td>
                        <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $item->prestasi->nama_prestasi }}</td>
                        <td><span class="badge bg-success">+{{ $item->prestasi->point }}</span></td>
                        <td>{{ $item->guru->nama ?? '-' }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('operasional.input-prestasi.show', $item->id) }}" class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('operasional.input-prestasi.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('operasional.input-prestasi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data prestasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">Data prestasi tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($prestasi->hasPages())
    <div class="card-footer clearfix">
        {{ $prestasi->links() }}
    </div>
    @endif
</div>
</div>
</div>
@endsection  --}}


@extends('layouts.app')

@section('title', 'Input Prestasi')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Input Prestasi</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Operasional</a></li>
                    <li class="breadcrumb-item active">Input Prestasi</li>
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
                <h3 class="card-title">Daftar Input Prestasi</h3>
                <div class="card-tools">
                    <a href="{{ route('operasional.input-prestasi.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Input Prestasi
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('operasional.input-prestasi.index') }}" class="row mb-3">
                    <div class="col-md-3">
                        <select name="kelas" class="form-select">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ request('kelas') == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="siswa" class="form-select">
                            <option value="">Semua Siswa</option>
                            @foreach($siswaList as $siswa)
                                <option value="{{ $siswa->id }}" {{ request('siswa') == $siswa->id ? 'selected' : '' }}>
                                    {{ $siswa->nis }} - {{ $siswa->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="start_date" class="form-control" 
                               value="{{ request('start_date') }}" placeholder="Dari Tanggal">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="end_date" class="form-control" 
                               value="{{ request('end_date') }}" placeholder="Sampai Tanggal">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Filter
                        </button>
                    </div>
                </form>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="12%">Kode</th>
                                <th width="10%">Tanggal</th>
                                <th width="15%">Siswa</th>
                                <th width="15%">Kelas</th>
                                <th width="20%">Prestasi</th>
                                <th width="8%">Poin</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inputs as $index => $item)
                            <tr>
                                <td>{{ $inputs->firstItem() + $loop->index }}</td>
                                <td><code>{{ $item->kode_transaksi }}</code></td>
                                <td>{{ $item->waktu->format('d/m/Y') }}</td>
                                <td>
                                    <strong>{{ $item->siswa->nama_lengkap ?? '-' }}</strong>
                                    <br><small>{{ $item->siswa->nis ?? '-' }}</small>
                                </td>
                                <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $item->prestasi->nama_prestasi ?? '-' }}</td>
                                <td><span class="badge bg-success">{{ $item->prestasi->point ?? 0 }}</span></td>
                                <td>
                                    <a href="{{ route('operasional.input-prestasi.show', $item->id) }}" 
                                       class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('operasional.input-prestasi.edit', $item->id) }}" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('operasional.input-prestasi.destroy', $item->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Yakin ingin menghapus data prestasi ini?')"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    <div class="alert alert-warning mb-0">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        Tidak ada data prestasi.
                                        <a href="{{ route('operasional.input-prestasi.create') }}" class="alert-link">
                                            Input prestasi baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-end mt-3">
                    {{ $inputs->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection