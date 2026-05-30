@extends('layouts.app')

@section('title', 'Detail Prestasi Siswa')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detail Prestasi Siswa</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('operasional.input-prestasi.index') }}">Input Prestasi</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                {{-- Profil Singkat Siswa --}}
                <div class="card card-success card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center mb-3">
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{ $data->siswa->user->foto_url ?? asset('images/default-avatar.png') }}"
                                 alt="User profile picture" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        <h3 class="profile-username text-center">{{ $data->siswa->nama_lengkap }}</h3>
                        <p class="text-muted text-center">NIS: {{ $data->siswa->nis }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Kelas</b> <a class="float-end text-decoration-none">{{ $data->kelas->nama_kelas }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Tahun Ajaran</b> <a class="float-end text-decoration-none">{{ $data->tahunAjaran->tahun_ajaran }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-info-circle me-1"></i> Informasi Transaksi
                        </h3>
                        <div class="card-tools float-end">
                            <button type="button" class="btn btn-tool" onclick="window.print()">
                                <i class="bi bi-printer"></i> Cetak
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 30%" class="bg-light">Kode Transaksi</th>
                                <td><code>{{ $data->kode_transaksi }}</code></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Waktu Kejadian</th>
                                <td>{{ $data->waktu->format('d F Y - H:i') }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Jenis Prestasi</th>
                                <td><strong>{{ $data->prestasi->nama_prestasi }}</strong></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Poin Penghargaan</th>
                                <td><span class="badge bg-success">+{{ $data->prestasi->point }} Poin</span></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Guru Pelapor</th>
                                <td>{{ $data->guru->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Keterangan</th>
                                <td>{{ $data->keterangan ?? 'Tidak ada keterangan tambahan.' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('operasional.input-prestasi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <a href="{{ route('operasional.input-prestasi.edit', $data->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil-square me-1"></i> Edit Data
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection