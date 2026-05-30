@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detail Siswa</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('master-data.siswa.index') }}">Siswa</a></li>
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
                        <h3 class="card-title">Informasi Siswa</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 35%">NIS</th>
                                <td><strong>{{ $siswa->nis }}</strong></td>
                            </tr>
                            <tr>
                                <th>NISN</th>
                                <td>{{ $siswa->nisn ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>{{ $siswa->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <th>Tempat / Tgl Lahir</th>
                                <td>
                                    {{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir->format('d/m/Y') }}
                                </td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>{{ $siswa->jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <th>Agama</th>
                                <td>{{ $siswa->agama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $siswa->alamat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>{{ $siswa->no_telp ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nama Ayah</th>
                                <td>{{ $siswa->nama_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nama Ibu</th>
                                <td>{{ $siswa->nama_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pekerjaan Orang Tua</th>
                                <td>{{ $siswa->pekerjaan_ortu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $siswa->user->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td><code>{{ $siswa->user->username }}</code></td>
                            </tr>
                            <tr>
                                <th>Status User</th>
                                <td>
                                    @if($siswa->user->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                    @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <div class="mt-3">
                            <a href="{{ route('master-data.siswa.edit', $siswa->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil me-2"></i> Edit
                            </a>
                            <a href="{{ route('master-data.siswa.reset-password', $siswa->id) }}"
                                class="btn btn-secondary"
                                onclick="return confirm('Reset password untuk {{ $siswa->nama_lengkap }}?')">
                                <i class="bi bi-key me-2"></i> Reset Password
                            </a>
                            <a href="{{ route('master-data.siswa.index') }}" class="btn btn-info">
                                <i class="bi bi-arrow-left me-2"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card Poin -->
                <div class="card mt-3">
                    <div class="card-header bg-info text-white">
                        <h3 class="card-title">Rekap Poin</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-danger"><i class="bi bi-exclamation-triangle"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Poin Pelanggaran</span>
                                        <span class="info-box-number">{{ $rekap->total_point_pelanggaran ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-success"><i class="bi bi-star"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Poin Prestasi</span>
                                        <span class="info-box-number">{{ $rekap->total_point_prestasi ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-primary"><i class="bi bi-calculator"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Poin Bersih</span>
                                        <span class="info-box-number">
                                            @php
                                            $poinBersih = ($rekap->total_point_prestasi ?? 0) - ($rekap->total_point_pelanggaran ?? 0);
                                            @endphp
                                            <span class="badge {{ $poinBersih >= 0 ? 'bg-success' : 'bg-danger' }} fs-5">
                                                {{ $poinBersih }}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <!-- Informasi Kelas -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Kelas Saat Ini</h3>
                    </div>
                    <div class="card-body">
                        @if($kelasAktif)
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <strong>{{ $kelasAktif->nama_kelas }}</strong>
                            (Tahun Ajaran: {{ $kelasAktif->tahunAjaran->nama ?? '-' }} - {{ $kelasAktif->tahunAjaran->semester ?? '-' }})
                            <br>
                            <small>Wali Kelas: {{ $kelasAktif->waliKelas->nama_lengkap ?? '-' }}</small>
                        </div>
                        <a href="{{ route('operasional.kelas-siswa.index') }}?siswa={{ $siswa->id }}"
                            class="btn btn-sm btn-info">
                            <i class="bi bi-arrow-right"></i> Lihat Riwayat Kelas
                        </a>
                        @else
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Siswa belum ditempatkan di kelas.
                            <a href="{{ route('operasional.kelas-siswa.create', ['siswa_id' => $siswa->id]) }}"
                                class="alert-link">Tempatkan sekarang</a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Riwayat Pelanggaran -->
                <div class="card mt-3">
                    <div class="card-header bg-danger text-white">
                        <h3 class="card-title">Riwayat Pelanggaran (10 Terakhir)</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Pelanggaran</th>
                                    <th>Poin</th>
                                    <th>Guru</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswa->inputPelanggaran as $item)
                                <tr>
                                    <td>{{ $item->waktu->format('d/m/Y') }}</td>
                                    <td>{{ $item->pelanggaran->nama_pelanggaran ?? '-' }}</td>
                                    <td><span class="badge bg-danger">{{ $item->pelanggaran->point ?? 0 }}</span></td>
                                    <td>{{ $item->guru->nama_lengkap ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada catatan pelanggaran</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Riwayat Prestasi -->
                <div class="card mt-3">
                    <div class="card-header bg-success text-white">
                        <h3 class="card-title">Riwayat Prestasi (10 Terakhir)</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Prestasi</th>
                                    <th>Poin</th>
                                    <th>Guru</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswa->inputPrestasi as $item)
                                <tr>
                                    <td>{{ $item->waktu->format('d/m/Y') }}</td>
                                    <td>{{ $item->prestasi->nama_prestasi ?? '-' }}</td>
                                    <td><span class="badge bg-success">{{ $item->prestasi->point ?? 0 }}</span></td>
                                    <td>{{ $item->guru->nama_lengkap ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada catatan prestasi</td>
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