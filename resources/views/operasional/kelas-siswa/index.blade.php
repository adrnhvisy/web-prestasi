@extends('layouts.app')

@section('title', 'Penempatan Kelas Siswa')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Penempatan Kelas Siswa</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Operasional</a></li>
                    <li class="breadcrumb-item active">Kelas Siswa</li>
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
                <h3 class="card-title">Daftar Penempatan Siswa</h3>
                <div class="card-tools">
                    <a href="{{ route('operasional.kelas-siswa.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Tambah Penempatan
                    </a>
                    <a href="#" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#bulkAssignModal">
                        <i class="bi bi-files"></i> Bulk Assign
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('operasional.kelas-siswa.index') }}" class="row mb-3">
                    <div class="col-md-3">
                        <select name="tahun_ajaran" class="form-select">
                            <option value="">Semua Tahun Ajaran</option>
                            @foreach($tahunAjaranList as $ta)
                                <option value="{{ $ta->id }}" {{ request('tahun_ajaran') == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->nama }} - {{ $ta->semester }}
                                    @if($ta->is_aktif) (Aktif) @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="kelas" class="form-select">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $itemKelas)
                                <option value="{{ $itemKelas->id }}" {{ request('kelas') == $itemKelas->id ? 'selected' : '' }}>
                                    {{ $itemKelas->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="alumni" {{ request('status') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Cari nama/NIS siswa..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="5%">NIS</th>
                                <th width="20%">Nama Siswa</th>
                                <th width="10%">Kelas</th>
                                <th width="15%">Tahun Ajaran</th>
                                <th width="10%">Tgl Masuk</th>
                                <th width="10%">Tgl Keluar</th>
                                <th width="5%">Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kelas as $index => $item)
                            <tr>
                                <td>{{ $kelas->firstItem() + $loop->index }}</td>
                                <td>{{ $item->waliKelas->nip ?? '-' }}</td>
                                <td><strong>{{ $item->waliKelas->nama ?? '-' }}</strong></td>
                                <td>{{ $item->nama_lengkap ?? '-' }}</td>
                                <td>{{ $item->tahunAjaran->nama ?? '-' }}</td>
                                <td>-</td>
                                <td>-</td>
                                <td>
                                    <span class="badge bg-success">Aktif</span>
                                </td>
                                <td>
                                    <a href="{{ route('master-data.kelas.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('master-data.kelas.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('master-data.kelas.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data kelas ini?')" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    <div class="alert alert-warning mb-0">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        Tidak ada data kelas tersedia.
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-end mt-3">
                    {{ $kelas->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="bulkAssignModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="#">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Bulk Assign Siswa ke Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Kelas Tujuan</label>
                        <select name="kelas_id" class="form-select" required>
                            <option value="">Pilih Kelas</option>
                            @foreach($kelasList as $itemKelas)
                                <option value="{{ $itemKelas->id }}">
                                    {{ $itemKelas->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Semua</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection