@extends('layouts.app')

@section('title', 'Edit Input Pelanggaran')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Input Pelanggaran</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('operasional.input-pelanggaran.index') }}">Input Pelanggaran</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
                <h3 class="card-title">Form Edit Pelanggaran</h3>
                <div class="card-tools">
                    <a href="{{ route('operasional.input-pelanggaran.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <strong>Kode Transaksi:</strong> <code>{{ $inputPelanggaran->kode_transaksi }}</code>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <strong>Siswa:</strong> {{ $inputPelanggaran->siswa->nis }} - {{ $inputPelanggaran->siswa->nama_lengkap }}
                            <br>
                            <strong>Kelas:</strong> {{ $inputPelanggaran->kelas->nama_kelas ?? '-' }}
                        </div>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('operasional.input-pelanggaran.update', $inputPelanggaran->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
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
                                                {{ old('pelanggaran_id', $inputPelanggaran->pelanggaran_id) == $p->id ? 'selected' : '' }}>
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
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="waktu" class="form-label">
                                    Tanggal Kejadian <span class="text-danger">*</span>
                                </label>
                                <input type="datetime-local" 
                                       class="form-control @error('waktu') is-invalid @enderror" 
                                       id="waktu" 
                                       name="waktu" 
                                       value="{{ old('waktu', $inputPelanggaran->waktu->format('Y-m-d\TH:i')) }}" 
                                       required>
                                @error('waktu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Informasi Poin</label>
                                <div class="alert alert-warning" id="info-poin">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    Poin: <span id="poin-terpilih">{{ $inputPelanggaran->pelanggaran->point ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Informasi Guru Pencatat</label>
                                <div class="alert alert-info">
                                    <i class="bi bi-person-badge me-2"></i>
                                    {{ $inputPelanggaran->user->nama ?? 'Tidak diketahui' }}
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
                                  placeholder="Masukkan keterangan tambahan (opsional)">{{ old('keterangan', $inputPelanggaran->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Perhatian:</strong> Mengubah data pelanggaran akan mempengaruhi perhitungan poin siswa. Pastikan data yang diinput sudah benar.
                    </div>
                    
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save me-2"></i> Update Pelanggaran
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
        $('#pelanggaran_id').on('change', function() {
            let selected = $(this).find(':selected');
            let point = selected.data('point') || 0;
            $('#poin-terpilih').text(point);
        });
    });
</script>
@endpush