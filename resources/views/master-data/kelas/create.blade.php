@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Tambah Kelas</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('master-data.kelas.index') }}">Kelas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Content -->
<div class="app-content">
    <div class="container-fluid">

        <!-- Error messages -->
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
                <h3 class="card-title">Form Tambah Kelas</h3>
                <div class="card-tools">
                    <a href="{{ route('master-data.kelas.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('master-data.kelas.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="tingkat" class="form-label">
                                    Tingkat Kelas <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('tingkat') is-invalid @enderror"
                                    id="tingkat" name="tingkat" required>
                                    <option value="">Pilih Tingkat</option>
                                    @foreach($tingkatList as $t)
                                    <option value="{{ $t }}" {{ old('tingkat') == $t ? 'selected' : '' }}>
                                        {{ $t }} ({{ $t == 'X' ? 'Sepuluh' : ($t == 'XI' ? 'Sebelas' : 'Dua Belas') }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('tingkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="jurusan_id" class="form-label">
                                    Jurusan <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('jurusan_id') is-invalid @enderror"
                                    id="jurusan_id" name="jurusan_id" required>
                                    <option value="">Pilih Jurusan</option>
                                    @foreach($jurusanList as $j)
                                    <option value="{{ $j->id }}"
                                        data-kode="{{ $j->kode_jurusan }}"
                                        {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>
                                        {{ $j->kode_jurusan }} - {{ $j->nama_jurusan }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('jurusan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="rombel" class="form-label">
                                    Rombel / Paralel <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                    class="form-control @error('rombel') is-invalid @enderror"
                                    id="rombel"
                                    name="rombel"
                                    value="{{ old('rombel', '1') }}"
                                    min="1" max="10"
                                    required>
                                @error('rombel')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Nomor rombongan belajar (1, 2, 3, ...)</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tahun_ajaran_id" class="form-label">
                                    Tahun Ajaran <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('tahun_ajaran_id') is-invalid @enderror"
                                    id="tahun_ajaran_id" name="tahun_ajaran_id" required>
                                    <option value="">Pilih Tahun Ajaran</option>
                                    @foreach($tahunAjaranList as $ta)
                                    <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->nama }} - {{ $ta->semester }}
                                        @if($ta->is_aktif) (Aktif) @endif
                                    </option>
                                    @endforeach
                                </select>
                                @error('tahun_ajaran_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="wali_kelas_id" class="form-label">Wali Kelas</label>
                                <select class="form-select @error('wali_kelas_id') is-invalid @enderror"
                                    id="wali_kelas_id" name="wali_kelas_id">
                                    <option value="">Pilih Wali Kelas (Opsional)</option>
                                    @foreach($guruList as $g)
                                    <option value="{{ $g->id }}" {{ old('wali_kelas_id') == $g->id ? 'selected' : '' }}>
                                        {{ $g->nama_lengkap }} ({{ $g->nip }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('wali_kelas_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Preview Nama Kelas -->
                    <div class="alert alert-info" id="preview-kelas" style="display: none;">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <strong>Preview:</strong>
                        <span id="preview-text"></span>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('master-data.kelas.index') }}" class="btn btn-secondary">
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
    // Gunakan try-catch agar jika ada library luar yang error (seperti OverlayScrollbars),
    // script Anda tetap berjalan.
    (function() {
        document.addEventListener('DOMContentLoaded', function() {
            const tingkatEl = document.getElementById('tingkat');
            const jurusanEl = document.getElementById('jurusan_id');
            const rombelEl = document.getElementById('rombel');
            const previewDiv = document.getElementById('preview-kelas');
            const previewText = document.getElementById('preview-text');

            if (!tingkatEl || !jurusanEl || !rombelEl) return;

            function updatePreview() {
                try {
                    const tingkat = tingkatEl.value;
                    const selectedJurusan = jurusanEl.options[jurusanEl.selectedIndex];
                    const kodeJurusan = selectedJurusan ? selectedJurusan.getAttribute('data-kode') : '';
                    const rombel = rombelEl.value;

                    if (tingkat && kodeJurusan && rombel) {
                        previewText.textContent = `${tingkat} ${kodeJurusan} ${rombel}`;
                        previewDiv.style.display = 'block';
                    } else {
                        previewDiv.style.display = 'none';
                    }
                } catch (e) {
                    console.error("Gagal update preview:", e);
                }
            }

            [tingkatEl, jurusanEl, rombelEl].forEach(el => {
                el.addEventListener('change', updatePreview);
                el.addEventListener('input', updatePreview); // Gunakan input agar lebih responsif
            });

            updatePreview();
        });
    })();
</script>
@endpush