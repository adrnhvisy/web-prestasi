@extends('layouts.app')

@section('title', 'Detail Guru')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detail Guru</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('master-data.guru.index') }}">Guru</a></li>
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
                            <h3 class="card-title">Informasi Guru</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 35%">NIP</th>
                                    <td><strong>{{ $guru->nip }}</strong></td>
                                </tr>
                                <tr>
                                    <th>NUPTK</th>
                                    <td>{{ $guru->nuptk ?? '-'}}</td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>{{ $guru->nama_lengkap ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat / Tgl Lahir</th>
                                    <td>
                                        {{ $guru->tempat_lahir }} /
                                        {{ $guru->tanggal_lahir ? $guru->tanggal_lahir->format('d/m/Y') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'}}</td>
                                </tr>
                                <tr>
                                    <th>Agama</th>
                                    <td>{{ $guru->agama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Pendidikan Terakhir</th>
                                    <td>{{ $guru->pendidikan_terakhir ?? '-'}}</td>
                                </tr>
                                <tr>
                                    <th>Jabatan</th>
                                    <td>{{ $guru->jabatan ?? '-'}}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $guru->alamat ?? '-'}}</td>
                                </tr>
                                <tr>
                                    <th>No. Telepon</th>
                                    <td>{{ $guru->no_telp ?? '-'}}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $guru->email ?? '-'}}</td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td><code>{{ $guru->user->username }}</code></td>
                                </tr>
                                <tr>
                                    <th>Status User</th>
                                    <td>
                                        @if ($guru->user && $guru->user->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <div class="mt-3">
                                <a href="{{ route('master-data.guru.edit', $guru->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil me-2"></i> Edit
                                </a>
                                <a href="{{ route('master-data.guru.reset-password', $guru->id) }}"
                                    class="btn btn-secondary"
                                    onclick="return confirm('Reset password untuk {{ $guru->nama_lengkap }}?')">
                                    <i class="bi bi-key me-2"></i> Reset Password
                                </a>
                                <a href="{{ route('master-data.guru.index') }}" class="btn btn-info">
                                    <i class="bi bi-arrow-left me-2"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Kelas yang Diasuh (Wali Kelas)</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Jml Siswa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($guru->waliKelas as $index => $kelas)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $kelas->nama_kelas }}</td>
                                            <td>{{ $kelas->jurusan->nama_jurusan ?? '-' }}</td>
                                            <td>{{ $kelas->tahunAjaran->nama ?? '-' }} -
                                                {{ $kelas->tahunAjaran->semester ?? '-' }}</td>
                                            <td class="text-center">{{ $kelas->jumlah_siswa_aktif }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak menjadi wali kelas</td>
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