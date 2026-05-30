@extends('layouts.app')

@section('title', 'Log Aktivitas Sistem')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Monitoring Log Aktivitas</h3>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <form action="{{ route('operasional.log-aktivitas.index') }}" method="GET" class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Cari aktivitas atau user..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="modul" class="form-select">
                            <option value="">Semua Modul</option>
                            @foreach($listModul as $m)
                            <option value="{{ $m }}" {{ request('modul') == $m ? 'selected' : '' }}>{{ strtoupper($m) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>User</th>
                            <th>Modul</th>
                            <th>Aktivitas</th>
                            <th>IP Address</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $l)
                        <tr>
                            <td>{{ $l->created_at->format('d/m/Y H:i') }}</td>
                            <td><strong>{{ $l->user->nama ?? 'System' }}</strong></td>
                            <td><span class="badge bg-secondary">{{ strtoupper($l->modul) }}</span></td>
                            <td>{{ $l->aktivitas }}</td>
                            <td><small class="text-muted">{{ $l->ip_address }}</small></td>
                            <td class="text-center">
                                <a href="{{ route('operasional.log-aktivitas.show', $l->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Tidak ada log aktivitas ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">{{ $logs->links() }}</div>
        </div>
    </div>
</div>
@endsection