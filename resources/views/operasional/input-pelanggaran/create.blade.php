@extends('layouts.app')

@section('title', 'Input Pelanggaran')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Input Pelanggaran</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('operasional.input-pelanggaran.index') }}">Input Pelanggaran</a></li>
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
                <h3 class="card-title">Form Input Pelanggaran</h3>
                <div class="card-tools">
                    <a href="{{ route('operasional.input-pelanggaran.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('operasional.input-pelanggaran.store') }}">
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
                                                ({{ $kelasAktif->nama_kelas }})
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
                                <label for="pelanggaran_id" class="form-label">
                                    Jenis Pelanggaran <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('pelanggaran_id') is-invalid @enderror" 
                                        id="pelanggaran_id" name="pelanggaran_id" required>
                                    <option value="">Pilih Pelanggaran</option>
                                    @foreach($pelanggaran as $p)
                                        <option value="{{ $p->id }}" 
                                                data-point="{{ $p->point }}"
                                                data-kategori="{{ $p->kategori->nama_kategori ?? '' }}"
                                                {{ old('pelanggaran_id') == $p->id ? 'selected' : '' }}>
                                            [{{ $p->kategori->nama_kategori ?? 'Umum' }}] 
                                            {{ $p->nama_pelanggaran }} ({{ $p->point }} poin)
                                        </option>
                                    @endforeach
                                </select>
                                @error('pelanggaran_id')
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
                                <div class="alert alert-warning" id="info-poin">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
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
                    
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i> Simpan Pelanggaran
                    </button>
                    <a href="{{ route('operasional.input-pelanggaran.index') }}" class="btn btn-secondary">
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
        
        $('#pelanggaran_id').on('change', function() {
            let selected = $(this).find(':selected');
            let point = selected.data('point') || 0;
            $('#poin-terpilih').text(point);
        });
        
        // Trigger on page load if values exist
        if ($('#siswa_id').val()) {
            $('#siswa_id').trigger('change');
        }
        if ($('#pelanggaran_id').val()) {
            $('#pelanggaran_id').trigger('change');
        }
    });
</script>
@endpush