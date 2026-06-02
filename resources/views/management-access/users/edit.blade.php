@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card card-warning card-outline">
        <div class="card-header">
            <h3 class="card-title">Edit User: {{ $user->username }}</h3>
        </div>
        <form action="{{ route('management-access.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $user->nama) }}" required>
                            @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="{{ $user->username }}" readonly>
                            <small class="text-muted">Username tidak dapat diubah untuk menjaga integritas log.</small>
                        </div>
                        <div class="form-group">
                            <label>Role / Hak Akses</label>
                            <select name="role" class="form-control @error('role') is-invalid @enderror" {{ !Auth::user()->canManageUsers() ? 'disabled' : '' }} required>
                                <option value="">-- Pilih Role --</option>
                                @foreach($hakAksesList as $key => $label)
                                    <option value="{{ $key }}" {{ old('role', $user->roles->first()?->name) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('role') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            
                            @if(!Auth::user()->canManageUsers())
                                <input type="hidden" name="role" value="{{ $user->roles->first()?->name }}">
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            <small class="text-info">Kosongkan jika tidak ingin mengubah password.</small>
                            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Status Akun</label>
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" name="is_active" class="custom-control-input" id="isActiveSwitch" value="1" {{ $user->is_active ? 'checked' : '' }} {{ $user->id == Auth::id() ? 'disabled' : '' }}>
                                <label class="custom-control-label" for="isActiveSwitch">Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('management-access.users.index') }}" class="btn btn-default">Batal</a>
                <button type="submit" class="btn btn-warning float-right">Update User</button>
            </div>
        </form>
    </div>
</div>
@endsection