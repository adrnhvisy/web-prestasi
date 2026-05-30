@extends('layouts.app')

@section('title', 'Tambah Guru')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Tambah Guru</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('master-data.guru.index') }}">Guru</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        {{-- Menampilkan Error Validasi atau Error Database --}}
        @if($errors->any() || session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Gagal menyimpan data:</strong>
            <ul class="mb-0 mt-2">
                @if(session('error'))
                <li>{{ session('error') }}</li>
                @endif
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Form Tambah Guru</h3>
                <div class="card-tools">
                    <a href="{{ route('master-data.guru.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('master-data.guru.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip"
                                    name="nip" value="{{ old('nip') }}" placeholder="Nomor Induk Pegawai" required>
                                @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nuptk" class="form-label">NUPTK</label>
                                <input type="text" class="form-control @error('nuptk') is-invalid @enderror" id="nuptk"
                                    name="nuptk" value="{{ old('nuptk') }}" placeholder="Nomor Unik Pendidik">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                    value="{{ old('tempat_lahir') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                    id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">Pilih</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                <select class="form-select" id="agama" name="agama">
                                    <option value="">Pilih</option>
                                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'] as $agama)
                                    <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>
                                        {{ $agama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                                <select class="form-select" id="pendidikan_terakhir" name="pendidikan_terakhir">
                                    <option value="">Pilih</option>
                                    @foreach(['D3', 'S1', 'S2', 'S3'] as $p)
                                    <option value="{{ $p }}" {{ old('pendidikan_terakhir') == $p ? 'selected' : '' }}>
                                        {{ $p }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan"
                                    value="{{ old('jabatan') }}" placeholder="Contoh: Guru Mapel">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_telp" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp"
                                    value="{{ old('no_telp') }}" placeholder="0812...">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email') }}" placeholder="guru@epoint.sch.id" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 bg-light p-4 rounded border shadow-sm">
                        <h6 class="fw-bold mb-3 text-dark">
                            <i class="bi bi-shield-lock me-2"></i>Informasi Akun Login
                        </h6>

                        <div class="row g-3">
                            {{-- Kolom Username --}}
                            <div class="col-md-6">
                                <label for="username" class="form-label fw-semibold">
                                    Username <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                                    <input type="text"
                                        class="form-control @error('username') is-invalid @enderror"
                                        id="username"
                                        name="username"
                                        value="{{ old('username') }}"
                                        placeholder="Contoh: budi.setiawan"
                                        required>
                                    @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Gunakan huruf kecil dan angka, tanpa spasi.</small>
                            </div>

                            {{-- Kolom Password --}}
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-key"></i></span>
                                    <input type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        id="password"
                                        name="password"
                                        placeholder="Kosongkan untuk default">
                                    <button class="btn btn-outline-secondary" type="button" id="btnToggle">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Info Box --}}
                        <div class="mt-3 p-2 bg-white border-start border-primary border-4 rounded shadow-sm">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-info-circle-fill text-primary fs-5 me-2"></i>
                                <div>
                                    <span class="text-dark d-block" style="font-size: 0.85rem;">
                                        Jika dikosongkan, password otomatis diset: <strong>guru123</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 border-top pt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                        <a href="{{ route('master-data.guru.index') }}" class="btn btn-outline-secondary px-4">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    // Logic Toggle Mata
    document.getElementById('btnToggle').addEventListener('click', function() {
        const pass = document.getElementById('password');
        const icon = this.querySelector('i');
        if (pass.type === 'password') {
            pass.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            pass.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
</script>
@endpush