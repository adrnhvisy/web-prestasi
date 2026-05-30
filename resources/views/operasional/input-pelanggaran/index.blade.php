@extends('layouts.app')

@section('title', 'Input Pelanggaran')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Input Pelanggaran</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Operasional</a></li>
                    <li class="breadcrumb-item active">Input Pelanggaran</li>
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
                <h3 class="card-title">Daftar Input Pelanggaran</h3>
                <div class="card-tools">
                    <a href="{{ route('operasional.input-pelanggaran.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Input Pelanggaran
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('operasional.input-pelanggaran.index') }}" class="row mb-3">
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
                                <th width="20%">Pelanggaran</th>
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
                                <td>{{ $item->pelanggaran->nama_pelanggaran ?? '-' }}</td>
                                <td><span class="badge bg-danger">{{ $item->pelanggaran->point ?? 0 }}</span></td>
                                <td>
                                    <a href="{{ route('operasional.input-pelanggaran.show', $item->id) }}" 
                                       class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('operasional.input-pelanggaran.edit', $item->id) }}" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('operasional.input-pelanggaran.destroy', $item->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Yakin ingin menghapus data pelanggaran ini?')"
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
                                        Tidak ada data pelanggaran.
                                        <a href="{{ route('operasional.input-pelanggaran.create') }}" class="alert-link">
                                            Input pelanggaran baru
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