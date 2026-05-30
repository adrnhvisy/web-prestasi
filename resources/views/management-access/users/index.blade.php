@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pengguna Sistem</h3>
                    <div class="card-tools">
                        <a href="{{ route('management-access.users.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah User
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('management-access.users.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Cari Nama/Username/Email..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="hak_akses" class="form-control">
                                    <option value="">-- Semua Hak Akses --</option>
                                    @foreach($hakAksesList as $key => $label)
                                    <option value="{{ $key }}" {{ request('hak_akses') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-info">Filter</button>
                            </div>
                        </div>
                    </form>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Hak Akses</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email ?? '-' }}</td>
                                <td>
                                    @php
                                    // Logika penentuan warna background secara manual
                                    $bgColor = '#17a2b8'; // Default Biru (Info)
                                    if ($user->hak_akses == 'superadmin') {
                                    $bgColor = '#dc3545'; // Merah (Danger)
                                    } elseif ($user->hak_akses == 'admin') {
                                    $bgColor = '#ffc107'; // Kuning (Warning)
                                    }
                                    @endphp

                                    <span class="badge"
                                        style="background-color: {{ $bgColor }} !important; 
                                        color: {{ $user->hak_akses == 'admin' ? 'black' : 'white' }} !important;
                                        padding: 5px 10px;
                                        border-radius: 4px;
                                        display: inline-block;">
                                        {{ strtoupper($user->hak_akses) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input toggle-active"
                                            id="switch-{{ $user->id }}"
                                            data-id="{{ $user->id }}"
                                            {{ $user->is_active ? 'checked' : '' }}
                                            {{ $user->id == Auth::id() ? 'disabled' : '' }}>
                                        <label class="custom-control-label" for="switch-{{ $user->id }}"></label>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('management-access.users.show', $user->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> Show</a>
                                    <a href="{{ route('management-access.users.edit', $user->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i>Edit</a>
                                    @if($user->id != Auth::id())
                                    <form action="{{ route('management-access.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus user ini?')"><i class="fas fa-trash"></i>Delete</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.toggle-active').change(function() {
        let id = $(this).data('id');
        $.ajax({
            url: `/management-access/users/${id}/toggle-active`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr) {
                alert(xhr.responseJSON.message);
                location.reload(); // Revert switch if failed
            }
        });
    });
</script>
@endpush