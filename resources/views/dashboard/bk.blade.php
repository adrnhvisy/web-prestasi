@extends('layouts.app')

@section('title', 'Dashboard BK - ePoint SMK Hasanah')

@section('page-title', 'Dashboard BK')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="container-fluid">

        <!-- Welcome Alert -->
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>
            <strong>Selamat Datang, {{ $user->name }}!</strong>
            Ini adalah dashboard sementara. Data yang ditampilkan masih statis.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <!-- Info Boxes -->
        <div class="row">
            <!-- Total Siswa -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $statistik['total_siswa'] }}</h3>
                        <p>Total Siswa</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Selengkapnya <i class="bi bi-arrow-right-circle ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Total Guru -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $statistik['total_guru'] }}</h3>
                        <p>Total Guru</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-person-workspace"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Selengkapnya <i class="bi bi-arrow-right-circle ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Total Kelas -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $statistik['total_kelas'] }}</h3>
                        <p>Total Kelas</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-door-open-fill"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Selengkapnya <i class="bi bi-arrow-right-circle ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Total Pelanggaran -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $statistik['total_pelanggaran'] }}</h3>
                        <p>Total Pelanggaran</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Selengkapnya <i class="bi bi-arrow-right-circle ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Chart & Info Row -->
        <div class="row">
            <!-- Chart Placeholder -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-graph-up me-2"></i>Statistik Bulanan
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="bi bi-dash-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-placeholder text-center py-5">
                            <i class="bi bi-bar-chart-fill fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">Grafik Statistik</h5>
                            <p class="text-muted mb-0">Data akan ditampilkan setelah fitur operasional aktif</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Tahun Ajaran -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">
                            <i class="bi bi-calendar-check me-2"></i>Tahun Ajaran Aktif
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <i class="bi bi-calendar3 fs-1 text-primary mb-3"></i>
                            <h4>2025/2026</h4>
                            <span class="badge bg-success">Semester Ganjil</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span><i class="bi bi-calendar me-1"></i> Mulai:</span>
                            <strong>15 Juli 2025</strong>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span><i class="bi bi-calendar-check me-1"></i> Selesai:</span>
                            <strong>20 Desember 2025</strong>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="card mt-3">
                    <div class="card-header bg-success text-white">
                        <h3 class="card-title">
                            <i class="bi bi-lightning-charge-fill me-2"></i>Akses Cepat
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="bi bi-exclamation-circle text-danger me-2"></i>
                                Input Pelanggaran
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="bi bi-star-fill text-warning me-2"></i>
                                Input Prestasi
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="bi bi-file-text me-2"></i>
                                Lihat Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities & Quick Stats -->
        <div class="row">
            <!-- Pelanggaran Terbaru -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3 class="card-title">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>Pelanggaran Terbaru
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Siswa</th>
                                        <th>Pelanggaran</th>
                                        <th>Point</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Data akan ditampilkan setelah ada input pelanggaran
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="#" class="btn btn-sm btn-outline-danger">
                            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Prestasi Terbaru -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h3 class="card-title">
                            <i class="bi bi-trophy-fill me-2"></i>Prestasi Terbaru
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Siswa</th>
                                        <th>Prestasi</th>
                                        <th>Point</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Data akan ditampilkan setelah ada input prestasi
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="#" class="btn btn-sm btn-outline-success">
                            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Ranking Siswa -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h3 class="card-title">
                            <i class="bi bi-trophy-fill me-2"></i>Top 10 Ranking Siswa
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th width="5%">Rank</th>
                                        <th width="30%">Nama Siswa</th>
                                        <th width="20%">Kelas</th>
                                        <th width="15%">Pelanggaran</th>
                                        <th width="15%">Prestasi</th>
                                        <th width="15%">Poin Bersih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i = 1; $i <= 10; $i++)
                                        <tr>
                                            <td>
                                                @if($i == 1)
                                                    <span class="badge bg-warning"><i class="bi bi-trophy-fill"></i> 1</span>
                                                @elseif($i == 2)
                                                    <span class="badge bg-secondary">2</span>
                                                @elseif($i == 3)
                                                    <span class="badge bg-danger">3</span>
                                                @else
                                                    {{ $i }}
                                                @endif
                                            </td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-muted text-center">
                        <i class="bi bi-info-circle me-1"></i>
                        Data ranking akan muncul setelah ada input pelanggaran dan prestasi
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('css')
    <style>
        /* Small Box */
        .small-box {
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .small-box .inner {
            padding: 1.25rem;
            color: white;
        }

        .small-box .inner h3 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.25rem;
        }

        .small-box .inner p {
            font-size: 1rem;
            margin-bottom: 0;
            opacity: 0.9;
        }

        .small-box .icon {
            position: absolute;
            top: 0.5rem;
            right: 1rem;
            font-size: 4rem;
            opacity: 0.3;
            color: white;
        }

        .small-box-footer {
            display: block;
            padding: 0.5rem 1.25rem;
            background: rgba(0, 0, 0, 0.1);
            color: white;
            text-decoration: none;
        }

        .small-box-footer:hover {
            background: rgba(0, 0, 0, 0.2);
            color: white;
        }

        /* Chart Placeholder */
        .chart-placeholder {
            min-height: 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 0.5rem;
        }

        .chart-placeholder i {
            opacity: 0.5;
        }

        /* Card */
        .card {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 1.25rem;
        }

        .card-header.bg-primary,
        .card-header.bg-success,
        .card-header.bg-danger,
        .card-header.bg-warning {
            color: white;
        }

        /* Table */
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
    </style>
@endpush