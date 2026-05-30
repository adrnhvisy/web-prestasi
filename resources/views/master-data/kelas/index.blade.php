@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Kelas</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('master-data.kelas.index') }}">Master Data</a></li>
                        <li class="breadcrumb-item active">Kelas</li>
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
                    <h3 class="card-title">Daftar Kelas</h3>
                    <div class="card-tools">
                        <a href="{{ route('master-data.kelas.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg"></i> Tambah Kelas
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3 mb-3">
                        <div class="col-md-3">
                            <select name="tahun_ajaran" class="form-select">
                                <option value="">Semua Tahun Ajaran</option>
                                @foreach($tahunAjaranList as $ta)
                                    <option value="{{ $ta->id }}" {{ request('tahun_ajaran') == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->nama }} - {{ $ta->semester }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="jurusan" class="form-select">
                                <option value="">Semua Jurusan</option>
                                @foreach($jurusanList as $j)
                                    <option value="{{ $j->id }}" {{ request('jurusan') == $j->id ? 'selected' : '' }}>
                                        {{ $j->kode_jurusan }} - {{ $j->nama_jurusan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="tingkat" class="form-select">
                                <option value="">Semua Tingkat</option>
                                @foreach($tingkatList as $t)
                                    <option value="{{ $t }}" {{ request('tingkat') == $t ? 'selected' : '' }}>
                                        {{ $t }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> Filter
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('master-data.kelas.index') }}" class="btn btn-secondary w-100">
                                <i class="bi bi-arrow-repeat"></i> Reset
                            </a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Kelas</th>
                                    <th width="20%">Jurusan</th>
                                    <th width="5%">Tingkat</th>
                                    <th width="6%">Rombel</th>
                                    <th width="15%">Tahun Ajaran</th>
                                    <th width="15%">Wali Kelas</th>
                                    <th width="10%">Jml Siswa</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kelas as $index => $item)
                                    <tr>
                                        <td>{{ $kelas->firstItem() + $loop->index }}</td>
                                        <td><strong>{{ $item->nama_kelas ?? '-'}}</strong></td>
                                        <td>{{ $item->jurusan->nama_jurusan ?? '-' }}</td>
                                        <td>{{ $item->tingkat }}</td>
                                        <td class="text-center">{{ $item->rombel }}</td>
                                        <td>{{ $item->tahunAjaran->nama ?? '-' }} - {{ $item->tahunAjaran->semester ?? '-' }}
                                        </td>
                                        <td>{{ $item->waliKelas->nama_lengkap ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-info">{{ $item->jumlah_siswa_aktif }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('master-data.kelas.show', $item->id) }}"
                                                class="btn btn-sm btn-info" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('master-data.kelas.edit', $item->id) }}"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('master-data.kelas.destroy', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus kelas {{ $item->nama_kelas }}?')"
                                                    title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada data kelas</td>
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
@endsection