@extends('layouts.app')

@section('title', 'Dashboard Admin - ePoint SMK Hasanah')

@section('page-title', 'Dashboard Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>
            <strong>Selamat Datang, {{ Auth::user()->name }}!</strong>
            Panel monitoring kedisiplinan dan prestasi siswa SMK Hasanah.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $statistik['total_siswa'] ?? 0 }}</h3>
                        <p>Total Siswa</p>
                    </div>
                    <div class="icon"><i class="bi bi-people-fill"></i></div>
                    <a href="{{ route('master-data.siswa.index') }}" class="small-box-footer">Selengkapnya <i class="bi bi-arrow-right-circle ms-1"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $statistik['total_guru'] ?? 0 }}</h3>
                        <p>Total Guru</p>
                    </div>
                    <div class="icon"><i class="bi bi-person-workspace"></i></div>
                    <a href="{{ route('master-data.guru.index') }}" class="small-box-footer">Selengkapnya <i class="bi bi-arrow-right-circle ms-1"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 class="text-white">{{ $statistik['total_kelas'] ?? 0 }}</h3>
                        <p class="text-white">Total Kelas</p>
                    </div>
                    <div class="icon"><i class="bi bi-door-open-fill"></i></div>
                    <a href="{{ route('master-data.kelas.index') }}" class="small-box-footer">Selengkapnya <i class="bi bi-arrow-right-circle ms-1"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $statistik['total_pelanggaran'] ?? 0 }}</h3>
                        <p>Total Pelanggaran</p>
                    </div>
                    <div class="icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
                    <a href="{{ route('master-data.pelanggaran.index') }}" class="small-box-footer">Selengkapnya <i class="bi bi-arrow-right-circle ms-1"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h3 class="card-title text-dark">
                            <i class="bi bi-graph-up me-2 text-primary"></i>Statistik Bulanan
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-placeholder text-center py-5">
                            <i class="bi bi-bar-chart-fill fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">Grafik Statistik</h5>
                            <p class="text-muted mb-0">Visualisasi tren pelanggaran vs prestasi akan muncul otomatis.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">
                        <i class="bi bi-calendar-check me-2"></i>Tahun Ajaran Aktif
                    </div>
                    <div class="card-body text-center">
                        <i class="bi bi-calendar3 fs-1 text-primary mb-2"></i>
                        <h4>{{ $tahunAjaran->nama ?? '2025/2026' }}</h4>
                        <span class="badge bg-success">{{ $tahunAjaran->semester ?? 'Ganjil' }}</span>
                        <hr>
                        <div class="d-flex justify-content-between small px-2">
                            <span class="text-muted">Mulai:</span>
                            <strong>{{ isset($tahunAjaran->mulai) ? $tahunAjaran->mulai->format('d M Y') : '15 Juli 2025' }}</strong>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mt-3">
                    <div class="card-header bg-success text-white fw-bold">
                        <i class="bi bi-lightning-charge-fill me-2"></i>Akses Cepat
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('master-data.pelanggaran.create') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-exclamation-circle text-danger me-2"></i> Input Pelanggaran
                        </a>
                        <a href="{{ route('master-data.prestasi.create') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-star-fill text-warning me-2"></i> Input Prestasi
                        </a>
                        <a href="" class="list-group-item list-group-item-action">
                            <i class="bi bi-file-text me-2"></i> Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h3 class="card-title fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Pelanggaran Terbaru</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Siswa</th>
                                        <th>Kasus</th>
                                        <th class="text-end pe-3">Poin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pelanggaranTerbaru ?? [] as $p)
                                        <tr>
                                            <td class="ps-3"><strong>{{ $p->siswa->nama }}</strong></td>
                                            <td class="small">{{ $p->kategori->nama }}</td>
                                            <td class="text-end pe-3"><span class="badge bg-danger">{{ $p->poin }}</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted">Belum ada input pelanggaran.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h3 class="card-title fw-bold"><i class="bi bi-trophy-fill me-2"></i>Prestasi Terbaru</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Siswa</th>
                                        <th>Prestasi</th>
                                        <th class="text-end pe-3">Poin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($prestasiTerbaru ?? [] as $pt)
                                        <tr>
                                            <td class="ps-3"><strong>{{ $pt->siswa->nama }}</strong></td>
                                            <td class="small">{{ $pt->nama_prestasi }}</td>
                                            <td class="text-end pe-3"><span class="badge bg-success">+{{ $pt->poin }}</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted">Belum ada input prestasi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning">
                        <h3 class="card-title fw-bold text-dark"><i class="bi bi-award-fill me-2"></i>Top 10 Ranking Siswa</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="10%" class="ps-3">Rank</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th class="text-center">Pelanggaran</th>
                                        <th class="text-center">Prestasi</th>
                                        <th class="text-end pe-3">Poin Bersih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topSiswa ?? [] as $index => $siswa)
                                        <tr>
                                            <td class="ps-3">
                                                @if($index == 0) <span class="badge bg-warning text-dark">#1</span>
                                                @elseif($index == 1) <span class="badge bg-secondary">#2</span>
                                                @elseif($index == 2) <span class="badge bg-danger">#3</span>
                                                @else {{ $index + 1 }} @endif
                                            </td>
                                            <td class="fw-bold">{{ $siswa->nama }}</td>
                                            <td>{{ $siswa->kelas->nama }}</td>
                                            <td class="text-center text-danger">-{{ $siswa->total_poin_pelanggaran }}</td>
                                            <td class="text-center text-success">+{{ $siswa->total_poin_prestasi }}</td>
                                            <td class="text-end pe-3 fw-bold">{{ $siswa->poin_bersih }}</td>
                                        </tr>
                                    @empty
                                        @for($i = 1; $i <= 5; $i++)
                                            <tr>
                                                <td colspan="6" class="text-center text-muted small py-2">Menunggu kalkulasi data...</td>
                                            </tr>
                                        @break
                                        @endfor
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

@push('css')
    <style>
        .small-box { border-radius: 0.75rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 1.5rem; position: relative; overflow: hidden; transition: transform 0.2s; }
        .small-box:hover { transform: translateY(-5px); }
        .small-box .inner { padding: 1.5rem; color: white; }
        .small-box .inner h3 { font-size: 2.2rem; font-weight: 800; margin-bottom: 0.25rem; }
        .small-box .inner p { font-size: 0.95rem; opacity: 0.9; }
        .small-box .icon { position: absolute; top: 0.5rem; right: 1rem; font-size: 3.5rem; opacity: 0.2; color: white; }
        .small-box-footer { display: block; padding: 0.6rem; background: rgba(0,0,0,0.15); color: white; text-decoration: none; text-align: center; font-size: 0.85rem; }
        .small-box-footer:hover { background: rgba(0,0,0,0.25); color: white; }
        .chart-placeholder { min-height: 250px; background: #f8f9fa; border: 2px dashed #dee2e6; border-radius: 0.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; }
        .card { border: none; border-radius: 0.75rem; }
        .table thead th { border-top: none; font-size: 0.8rem; text-transform: uppercase; }
    </style>
@endpush