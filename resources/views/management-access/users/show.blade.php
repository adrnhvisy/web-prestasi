@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                             src="{{ $user->foto_url }}"
                             alt="User profile picture">
                    </div>
                    <h3 class="profile-username text-center">{{ $user->nama }}</h3>
                    <p class="text-muted text-center">{{ strtoupper($user->roles->first()?->name ?? '-') }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Status Akun</b> 
                            <a class="float-right">
                                <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>Username</b> <a class="float-right">{{ $user->username }}</a>
                        </li>
                    </ul>
                    <a href="{{ route('management-access.users.edit', $user->id) }}" class="btn btn-primary btn-block"><b>Edit Profil</b></a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#kontak" data-toggle="tab">Informasi Kontak</a></li>
                        @if($user->hasAnyRole(['siswa', 'guru', 'bk']))
                        <li class="nav-item"><a class="nav-link" href="#akademik" data-toggle="tab">Data Akademik</a></li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="kontak">
                            <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                            <p class="text-muted">{{ $user->email ?? 'Tidak ada email' }}</p>
                            <hr>
                            <strong><i class="fas fa-phone mr-1"></i> No. Telepon</strong>
                            <p class="text-muted">{{ $user->no_telp ?? '-' }}</p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                            <p class="text-muted">{{ $user->alamat ?? '-' }}</p>
                        </div>

                        @if($user->hasAnyRole(['siswa', 'guru', 'bk']))
                        <div class="tab-pane" id="akademik">
                            @if($user->isSiswa() && $user->siswa)
                                <table class="table table-sm">
                                    <tr><th style="width: 30%">NISN</th><td>: {{ $user->siswa->nisn }}</td></tr>
                                    <tr><th>Kelas Saat Ini</th><td>: {{ $user->siswa->kelasSiswa->first()->kelas->nama_kelas ?? 'Belum ada kelas' }}</td></tr>
                                    <tr><th>Total Poin</th><td>: <span class="badge badge-info">{{ $user->siswa->total_poin ?? 0 }}</span></td></tr>
                                </table>
                            @elseif(($user->isGuru() || $user->isBK()) && $user->guru)
                                <table class="table table-sm">
                                    <tr><th style="width: 30%">NIP</th><td>: {{ $user->guru->nip }}</td></tr>
                                    <tr><th>Jabatan</th><td>: {{ $user->guru->jabatan }}</td></tr>
                                </table>
                            @else
                                <p class="text-center text-muted">Data detail belum dilengkapi.</p>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection