@extends('layouts.auth')

@section('title', 'Login - E-Point SMK Hasanah')

@section('auth-content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" 
                       class="form-control @error('username') is-invalid @enderror" 
                       id="username" 
                       name="username" 
                       value="{{ old('username') }}" 
                       placeholder="Masukkan username"
                       required autofocus>
            </div>
            @error('username')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       placeholder="Masukkan password"
                       required>
            </div>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>
            {{-- <a href="{{ route('password.request') }}" class="text-decoration-none small">Lupa password?</a> --}}
        </div>
        
        <button type="submit" class="btn btn-primary w-100 py-2">
            <i class="bi bi-box-arrow-in-right me-2"></i> Login
        </button>
    </form>

    <hr class="my-4">
    
    @if(Route::has('register'))
    <div class="text-center mb-3">
        <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none">Daftar sekarang</a></p>
    </div>
    @endif
    
@endsection