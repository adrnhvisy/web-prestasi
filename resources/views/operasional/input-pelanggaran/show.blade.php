@extends('layouts.app')

@section('title', 'Detail Pelanggaran')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detail Pelanggaran</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('operasional.input-pelanggaran.index') }}">Input
                                Pelanggaran</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Pelanggaran</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 35%">Kode Transaksi</th>
                                    <td><code>{{ $inputPelanggaran->kode_transaksi }}</code></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kejadian</th>
                                    <td>{{ $inputPelanggaran->waktu->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Siswa</th>
                                    <td>
                                        <strong>{{ $inputPelanggaran->siswa->nama_lengkap ?? '-' }}</strong>
                                        <br><small>NIS: {{ $inputPelanggaran->siswa->nis ?? '-' }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Kelas</th>
                                    <td>{{ $inputPelanggaran->kelas->nama_kelas ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Pelanggaran</th>
                                    <td>
                                        {{ $inputPelanggaran->pelanggaran->nama_pelanggaran ?? '-' }}
                                        <br><small>Kategori:
                                            {{ $inputPelanggaran->pelanggaran->kategori->nama_kategori ?? '-' }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Poin</th>
                                    <td><span
                                            class="badge bg-danger">{{ $inputPelanggaran->pelanggaran->point ?? 0 }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Guru Pencatat</th>
                                    <td>{{ $inputPelanggaran->user->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>{{ $inputPelanggaran->keterangan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tahun Ajaran</th>
                                    <td>{{ $inputPelanggaran->tahunAjaran->nama ?? '-' }} -
                                        {{ $inputPelanggaran->tahunAjaran->semester ?? '-' }}</td>
                                </tr>
                            </table>

                            <div class="mt-3">
                                <a href="{{ route('operasional.input-pelanggaran.edit', $inputPelanggaran->id) }}"
                                    class="btn btn-warning">
                                    <i class="bi bi-pencil me-2"></i> Edit
                                </a>
                                <a href="{{ route('operasional.input-pelanggaran.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Siswa</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 35%">NIS</th>
                                    <td>{{ $inputPelanggaran->siswa->nis ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>{{ $inputPelanggaran->siswa->nama_lengkap ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kelas</th>
                                    <td>{{ $inputPelanggaran->kelas->nama_kelas ?? '-' }}</td>
                                </tr>
                            </table>

                            <a href="{{ route('master-data.siswa.show', $inputPelanggaran->siswa_id) }}"
                                class="btn btn-info">
                                <i class="bi bi-person"></i> Lihat Detail Siswa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection