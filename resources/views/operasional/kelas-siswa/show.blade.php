@extends('layouts.app')

@section('title', 'Detail Penempatan')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detail Penempatan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('operasional.kelas-siswa.index') }}">Kelas Siswa</a></li>
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
                        <h3 class="card-title">Informasi Penempatan</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 35%">NIS</th>
                                <td>{{ $kelasSiswa->siswa->nis ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nama Siswa</th>
                                <td><strong>{{ $kelasSiswa->siswa->nama_lengkap ?? '-' }}</strong></td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td>{{ $kelasSiswa->kelas->nama_kelas ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tahun Ajaran</th>
                                <td>{{ $kelasSiswa->tahunAjaran->nama ?? '-' }} - {{ $kelasSiswa->tahunAjaran->semester ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Masuk</th>
                                <td>{{ $kelasSiswa->tanggal_masuk ? $kelasSiswa->tanggal_masuk->format('d/m/Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Keluar</th>
                                <td>{{ $kelasSiswa->tanggal_keluar ? $kelasSiswa->tanggal_keluar->format('d/m/Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{!! $kelasSiswa->status_badge !!}</td>
                            </tr>
                            <tr>
                                <th>Lama di Kelas</th>
                                <td>
                                    @if($kelasSiswa->tanggal_masuk)
                                        @php
                                            $akhir = $kelasSiswa->tanggal_keluar ?? now();
                                            $lama = $kelasSiswa->tanggal_masuk->diffInDays($akhir);
                                            $bulan = floor($lama / 30);
                                            $hari = $lama % 30;
                                        @endphp
                                        {{ $bulan }} bulan {{ $hari }} hari
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </table>
                        
                        <div class="mt-3">
                            <a href="{{ route('operasional.kelas-siswa.edit', $kelasSiswa->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil me-2"></i> Edit
                            </a>
                            @if(!$kelasSiswa->tanggal_keluar)
                            <form action="{{ route('operasional.kelas-siswa.graduate', $kelasSiswa->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success" 
                                        onclick="return confirm('Tandai siswa ini lulus/keluar?')">
                                    <i class="bi bi-box-arrow-right me-2"></i> Tandai Lulus
                                </button>
                            </form>
                            @endif
                            <a href="{{ route('master-data.siswa.show', $kelasSiswa->siswa_id) }}" 
                               class="btn btn-info">
                                <i class="bi bi-person"></i> Detail Siswa
                            </a>
                            <a href="{{ route('operasional.kelas-siswa.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Kelas</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 35%">Nama Kelas</th>
                                <td>{{ $kelasSiswa->kelas->nama_kelas ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tingkat</th>
                                <td>{{ $kelasSiswa->kelas->tingkat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jurusan</th>
                                <td>{{ $kelasSiswa->kelas->jurusan->nama_jurusan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Rombel</th>
                                <td>{{ $kelasSiswa->kelas->rombel ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Wali Kelas</th>
                                <td>{{ $kelasSiswa->kelas->waliKelas->nama_lengkap ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Siswa</th>
                                <td>
                                    @php
                                        $jumlahSiswa = \App\Models\Operasional\KelasSiswa::where('kelas_id', $kelasSiswa->kelas_id)
                                            ->where('tahun_ajaran_id', $kelasSiswa->tahun_ajaran_id)
                                            ->whereNull('tanggal_keluar')
                                            ->count();
                                    @endphp
                                    {{ $jumlahSiswa }} siswa
                                </td>
                            </tr>
                        </table>
                        
                        <a href="{{ route('master-data.kelas.show', $kelasSiswa->kelas_id) }}" 
                           class="btn btn-info">
                            <i class="bi bi-building"></i> Detail Kelas
                        </a>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Riwayat Kelas Siswa</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tahun Ajaran</th>
                                    <th>Kelas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $riwayat = \App\Models\Operasional\KelasSiswa::with(['kelas', 'tahunAjaran'])
                                        ->where('siswa_id', $kelasSiswa->siswa_id)
                                        ->orderBy('tahun_ajaran_id', 'desc')
                                        ->orderBy('created_at', 'desc')
                                        ->get();
                                @endphp
                                @forelse($riwayat as $r)
                                <tr>
                                    <td>{{ $r->tahunAjaran->nama ?? '-' }} - {{ $r->tahunAjaran->semester ?? '-' }}</td>
                                    <td>{{ $r->kelas->nama_kelas ?? '-' }}</td>
                                    <td>{!! $r->status_badge !!}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada riwayat</td>
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