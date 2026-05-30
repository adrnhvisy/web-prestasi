{{-- 
@extends('layouts.app')

@section('title', 'Input Prestasi Baru')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Catat Prestasi Siswa</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('operasional.input-prestasi.index') }}">Input Prestasi</a></li>
                    <li class="breadcrumb-item active">Tambah Baru</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Form Input Prestasi</h3>
                    </div>

                    <form action="{{ route('operasional.input-prestasi.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <div class="mb-3">
                                <label for="siswa_id" class="form-label">Pilih Siswa <span class="text-danger">*</span></label>
                                <select name="siswa_id" id="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                                    <option value="">-- Cari Nama atau NIS Siswa --</option>
                                    @foreach($dataSiswa as $s)
                                    <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->nis }} - {{ $s->nama_lengkap }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('siswa_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Siswa harus terdaftar di kelas aktif pada tahun ajaran ini.</small>
                            </div>

                            <div class="mb-3">
                                <label for="prestasi_id" class="form-label">Jenis Prestasi <span class="text-danger">*</span></label>
                                <select name="prestasi_id" id="prestasi_id" class="form-select @error('prestasi_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Jenis Prestasi --</option>
                                    @foreach($dataPrestasi as $p)
                                    <option value="{{ $p->id }}" {{ old('prestasi_id') == $p->id ? 'selected' : '' }}>
                                        [+{{ $p->point }} Poin] {{ $p->nama_prestasi }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('prestasi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan Tambahan (Opsional)</label>
                                <textarea name="keterangan" id="keterangan" rows="4" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Contoh: Juara 1 Lomba Matematika tingkat Provinsi...">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <a href="{{ route('operasional.input-prestasi.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1"></i> Simpan Prestasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h3 class="card-title"><i class="bi bi-info-circle me-2"></i>Informasi Prestasi</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-sm text-muted">
                            Pencatatan prestasi akan memengaruhi:
                        </p>
                        <ul class="text-sm ps-3">
                            <li><strong>Akumulasi Poin:</strong> Menambah total poin penghargaan siswa.</li>
                            <li><strong>Riwayat:</strong> Tercatat otomatis pada <strong>Waktu</strong> penginputan saat ini.</li>
                            <li><strong>Otomatisasi:</strong> Sistem menentukan <strong>Kelas & Tahun Ajaran</strong> berdasarkan data aktif siswa.</li>
                            <li><strong>Verifikasi:</strong> Dicatat oleh <strong>{{ Auth::user()->nama }}</strong>.</li>
                        </ul>
                        <div class="alert alert-light border text-sm mt-3">
                            Pastikan data sudah benar. Kode transaksi unik (ACH-...) akan dibuat setelah form disimpan.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

 --}}

@extends('layouts.app')

@section('title', 'Input Prestasi')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Input Prestasi</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('operasional.input-prestasi.index') }}">Input Prestasi</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Input Prestasi</h3>
                <div class="card-tools">
                    <a href="{{ route('operasional.input-prestasi.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('operasional.input-prestasi.store') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="siswa_id" class="form-label">
                                    Pilih Siswa <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('siswa_id') is-invalid @enderror" 
                                        id="siswa_id" name="siswa_id" required>
                                    <option value="">Pilih Siswa</option>
                                    @foreach($siswa as $s)
                                        @php
                                            $kelasAktif = $s->kelasSiswa->first()?->kelas;
                                        @endphp
                                        <option value="{{ $s->id }}" 
                                                data-kelas="{{ $kelasAktif?->id }}"
                                                data-kelas-nama="{{ $kelasAktif?->nama_lengkap }}"
                                                {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->nis }} - {{ $s->nama_lengkap }}
                                            @if($kelasAktif)
                                                ({{ $kelasAktif->nama_lengkap }})
                                            @else
                                                (Belum punya kelas)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('siswa_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="prestasi_id" class="form-label">
                                    Jenis Prestasi <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('prestasi_id') is-invalid @enderror" 
                                        id="prestasi_id" name="prestasi_id" required>
                                    <option value="">Pilih Prestasi</option>
                                    @foreach($prestasi as $p)
                                        <option value="{{ $p->id }}" 
                                                data-point="{{ $p->point }}"
                                                data-kategori="{{ $p->kategori->nama_kategori ?? '' }}"
                                                {{ old('prestasi_id') == $p->id ? 'selected' : '' }}>
                                            [{{ $p->kategori->nama_kategori ?? 'Umum' }}] 
                                            {{ $p->nama_prestasi }} ({{ $p->point }} poin)
                                        </option>
                                    @endforeach
                                </select>
                                @error('prestasi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="waktu" class="form-label">
                                    Tanggal Kejadian <span class="text-danger">*</span>
                                </label>
                                <input type="datetime-local" 
                                       class="form-control @error('waktu') is-invalid @enderror" 
                                       id="waktu" 
                                       name="waktu" 
                                       value="{{ old('waktu', now()->format('Y-m-d\TH:i')) }}" 
                                       required>
                                @error('waktu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Informasi</label>
                                <div class="alert alert-info" id="info-kelas" style="display: none;">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <span id="kelas-terpilih"></span>
                                </div>
                                <div class="alert alert-success" id="info-poin">
                                    <i class="bi bi-star-fill me-2"></i>
                                    Poin: <span id="poin-terpilih">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                  id="keterangan" 
                                  name="keterangan" 
                                  rows="3"
                                  placeholder="Masukkan keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-star me-2"></i> Simpan Prestasi
                    </button>
                    <a href="{{ route('operasional.input-prestasi.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#siswa_id').on('change', function() {
            let selected = $(this).find(':selected');
            let kelasNama = selected.data('kelas-nama');
            
            if (kelasNama) {
                $('#kelas-terpilih').text('Kelas: ' + kelasNama);
                $('#info-kelas').show();
            } else {
                $('#info-kelas').hide();
            }
        });
        
        $('#prestasi_id').on('change', function() {
            let selected = $(this).find(':selected');
            let point = selected.data('point') || 0;
            $('#poin-terpilih').text(point);
        });
        
        // Trigger on page load if values exist
        if ($('#siswa_id').val()) {
            $('#siswa_id').trigger('change');
        }
        if ($('#prestasi_id').val()) {
            $('#prestasi_id').trigger('change');
        }
    });
</script>
@endpush