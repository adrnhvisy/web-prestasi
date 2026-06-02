@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Pengguna Baru</h3>
        </div>
        <form action="{{ route('management-access.users.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama') }}" required>
                            @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username') }}" required>
                            @error('username') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}">
                            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Role / Hak Akses</label>
                            <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                                <option value="">-- Pilih Role --</option>
                                @foreach($hakAksesList as $key => $label)
                                    <option value="{{ $key }}" {{ old('role') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('role') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('management-access.users.index') }}" class="btn btn-secondary mr-2">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan & Lanjutkan</button>
            </div>
        </form>
    </div>
@endsection