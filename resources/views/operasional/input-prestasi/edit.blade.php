@extends('layouts.app')

@section('title', 'Edit Data Prestasi')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Prestasi Siswa</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('operasional.input-prestasi.index') }}">Input Prestasi</a></li>
                    <li class="breadcrumb-item active">Edit Data</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit Prestasi: <code>{{ $inputPrestasi->kode_transaksi }}</code></h3>
                    </div>

                    <form action="{{ route('operasional.input-prestasi.update', $inputPrestasi->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            {{-- Alert Error --}}
                            @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">Data Siswa (Read-only)</label>
                                <input type="text" class="form-control bg-light" value="{{ $inputPrestasi->siswa->nis }} - {{ $inputPrestasi->siswa->nama_lengkap }}" readonly>
                                <input type="hidden" name="siswa_id" value="{{ $inputPrestasi->siswa_id }}">
                                <small class="text-muted">Nama siswa dan NIS tidak dapat diubah setelah data tersimpan.</small>
                            </div>

                            <div class="mb-3">
                                <label for="prestasi_id" class="form-label">Jenis Prestasi <span class="text-danger">*</span></label>
                                <select name="prestasi_id" id="prestasi_id" class="form-select @error('prestasi_id') is-invalid @enderror" required>
                                    @foreach($dataPrestasi as $p)
                                    <option value="{{ $p->id }}" {{ (old('prestasi_id', $inputPrestasi->prestasi_id) == $p->id) ? 'selected' : '' }}>
                                        [+{{ $p->point }} Poin] {{ $p->nama_prestasi }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('prestasi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan Tambahan</label>
                                <textarea name="keterangan" id="keterangan" rows="4" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $inputPrestasi->keterangan) }}</textarea>
                                @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <a href="{{ route('operasional.input-prestasi.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle me-1"></i> Perbarui Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="bi bi-clock-history me-2"></i>Metadata</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm mb-0">
                            <tr>
                                <th class="ps-3 py-2 text-muted">Tanggal Input</th>
                                <td class="pe-3 py-2 text-end">{{ $inputPrestasi->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th class="ps-3 py-2 text-muted">Diinput Oleh</th>
                                <td class="pe-3 py-2 text-end">{{ $inputPrestasi->guru->nama ?? 'Sistem' }}</td>
                            </tr>
                            <tr>
                                <th class="ps-3 py-2 text-muted">Kelas Saat Ini</th>
                                <td class="pe-3 py-2 text-end">{{ $inputPrestasi->kelas->nama_kelas }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection