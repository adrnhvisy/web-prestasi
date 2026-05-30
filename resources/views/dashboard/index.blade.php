@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        
        <!-- Info Tahun Ajaran -->
        <div class="alert alert-info">
            <i class="bi bi-calendar-check me-2"></i>
            <strong>Tahun Ajaran Aktif:</strong> 2025/2026 - Ganjil
        </div>
        
        <!-- Statistik Cards -->
        <div class="row">
            <div class="col-lg-2 col-6">
                <div class="small-box text-bg-info">
                    <div class="inner">
                        <h3>450</h3>
                        <p>Siswa</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-6">
                <div class="small-box text-bg-success">
                    <div class="inner">
                        <h3>45</h3>
                        <p>Guru</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-person-badge"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-6">
                <div class="small-box text-bg-primary">
                    <div class="inner">
                        <h3>25</h3>
                        <p>Kelas</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-building"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-6">
                <div class="small-box text-bg-secondary">
                    <div class="inner">
                        <h3>50</h3>
                        <p>User</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-6">
                <div class="small-box text-bg-warning">
                    <div class="inner">
                        <h3>125</h3>
                        <p>Pelanggaran</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-6">
                <div class="small-box text-bg-danger">
                    <div class="inner">
                        <h3>78</h3>
                        <p>Prestasi</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-star"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Grafik -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Grafik 7 Hari Terakhir</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="mainChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Statistik Hari Ini</h3>
                    </div>
                    <div class="card-body">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-danger"><i class="bi bi-exclamation-triangle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Pelanggaran Hari Ini</span>
                                <span class="info-box-number">5</span>
                            </div>
                        </div>
                        
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-success"><i class="bi bi-star"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Prestasi Hari Ini</span>
                                <span class="info-box-number">3</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Top Ranking -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Top 10 Ranking Siswa</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Poin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-warning">
                                    <td>🥇 1</td>
                                    <td>2025004</td>
                                    <td>Citra Dewi</td>
                                    <td>X RPL 1</td>
                                    <td><span class="badge bg-success">+125</span></td>
                                </tr>
                                <tr class="table-warning">
                                    <td>🥈 2</td>
                                    <td>2025002</td>
                                    <td>Budi Santoso</td>
                                    <td>X RPL 1</td>
                                    <td><span class="badge bg-success">+98</span></td>
                                </tr>
                                <tr class="table-warning">
                                    <td>🥉 3</td>
                                    <td>2025005</td>
                                    <td>Dodi Saputra</td>
                                    <td>X RPL 1</td>
                                    <td><span class="badge bg-success">+87</span></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>2025001</td>
                                    <td>Ahmad Fauzi</td>
                                    <td>X RPL 1</td>
                                    <td><span class="badge bg-danger">-30</span></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>2025003</td>
                                    <td>Eka Putri</td>
                                    <td>X RPL 1</td>
                                    <td><span class="badge bg-danger">-15</span></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>2025006</td>
                                    <td>Fajar Ramadhan</td>
                                    <td>XI RPL 1</td>
                                    <td><span class="badge bg-success">+55</span></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>2025007</td>
                                    <td>Gita Sari</td>
                                    <td>XI RPL 1</td>
                                    <td><span class="badge bg-success">+42</span></td>
                                 </tr>
                                <tr>
                                    <td>8</td>
                                    <td>2025008</td>
                                    <td>Hendra Wijaya</td>
                                    <td>X TKJ 1</td>
                                    <td><span class="badge bg-danger">-25</span></td>
                                 </tr>
                                <tr>
                                    <td>9</td>
                                    <td>2025009</td>
                                    <td>Indah Permata</td>
                                    <td>X AKL 1</td>
                                    <td><span class="badge bg-success">+38</span></td>
                                 </tr>
                                <tr>
                                    <td>10</td>
                                    <td>2025010</td>
                                    <td>Joko Susilo</td>
                                    <td>X RPL 2</td>
                                    <td><span class="badge bg-success">+22</span></td>
                                 </tr>
                            </tbody>
                         </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('mainChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [
                    {
                        label: 'Pelanggaran',
                        data: [12, 8, 15, 10, 7, 5, 3],
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        tension: 0.4
                    },
                    {
                        label: 'Prestasi',
                        data: [5, 7, 4, 9, 6, 8, 4],
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    });
</script>
@endpush