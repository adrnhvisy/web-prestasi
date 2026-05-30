@extends('layouts.app')

@section('title', 'Detail Kelas')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detail Kelas</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('master-data.kelas.index') }}">Kelas</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Kelas</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 40%">Nama Kelas</th>
                                    <td><strong>{{ $kelas->nama_kelas }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Tingkat</th>
                                    <td>{{ $kelas->tingkat }}</td>
                                </tr>
                                <tr>
                                    <th>Jurusan</th>
                                    <td>{{ $kelas->jurusan->nama_jurusan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Rombel / Paralel</th>
                                    <td>{{ $kelas->rombel }}</td>
                                </tr>
                                <tr>
                                    <th>Tahun Ajaran</th>
                                    <td>
                                        {{ $kelas->tahunAjaran->nama ?? '-' }} - {{ $kelas->tahunAjaran->semester ?? '-' }}
                                        @if($kelas->tahunAjaran && $kelas->tahunAjaran->is_aktif)
                                            <span class="badge bg-success ms-2">Aktif</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Wali Kelas</th>
                                    <td>
                                        @if($kelas->waliKelas)
                                            {{ $kelas->waliKelas->nama_lengkap }} <br>
                                            <small class="text-muted">NIP: {{ $kelas->waliKelas->nip }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jumlah Siswa Aktif</th>
                                    <td>
                                        <span class="badge bg-info fs-6">{{ $kelas->kelasSiswa->count() }}</span> siswa
                                    </td>
                                </tr>
                            </table>

                            <div class="mt-3">
                                <a href="{{ route('master-data.kelas.edit', $kelas->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil me-2"></i> Edit
                                </a>
                                <a href="{{ route('master-data.kelas.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Siswa</h3>
                            <div class="card-tools">
                                <a href="{{ route('operasional.kelas-siswa.create') }}?kelas_id={{ $kelas->id }}"
                                    class="btn btn-primary btn-sm">
                                    <i class="bi bi-person-plus"></i> Tambah Siswa
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kelas->kelasSiswa as $index => $ks)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $ks->siswa->nis ?? '-' }}</td>
                                            <td>{{ $ks->siswa->nama_lengkap ?? '-' }}</td>
                                            <td>{{ $ks->siswa->jenis_kelamin == 'L' ? 'Laki-laki' : ($ks->siswa->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}
                                            </td>
                                            <td>
                                                <a href="{{ route('master-data.siswa.show', $ks->siswa_id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <div class="alert alert-warning mb-0">
                                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                                    Belum ada siswa di kelas ini.
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection