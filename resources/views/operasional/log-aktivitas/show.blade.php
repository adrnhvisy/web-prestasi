@extends('layouts.app')

@section('title', 'Detail Log Aktivitas')

@section('content')
<div class="app-content">
    <div class="container-fluid pt-4">
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h3 class="card-title">Informasi Dasar</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table mb-0">
                            <tr>
                                <th class="bg-light" style="width: 40%">Waktu</th>
                                <td>{{ $log->created_at->format('d F Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Pelaku</th>
                                <td>{{ $log->user->nama }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Modul</th>
                                <td>{{ strtoupper($log->modul) }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">IP Address</th>
                                <td>{{ $log->ip_address }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">User Agent</th>
                                <td><small>{{ $log->user_agent }}</small></td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('operasional.log-aktivitas.index') }}" class="btn btn-secondary w-100">Kembali</a>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h3 class="card-title">Payload / Data Perubahan</h3>
                    </div>
                    <div class="card-body">
                        @if($log->data)
                        <pre class="bg-light p-3 border rounded"><code>{{ json_encode($log->data, JSON_PRETTY_PRINT) }}</code></pre>
                        @else
                        <p class="text-muted">Tidak ada data tambahan untuk aktivitas ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection