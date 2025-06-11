@extends('adminlte::page')

@section('title', 'Tambah Tutor Baru')

@section('content_header')
    <h1>Tambah Tutor Baru</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Formulir Tambah Tutor</h3>
        </div>
        <form action="{{ route('tutors.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Tutor</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Masukkan nama lengkap tutor" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone_number">No. Telepon</label>
                    <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" placeholder="Masukkan nomor telepon" value="{{ old('phone_number') }}">
                    @error('phone_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="specialization">Spesialisasi</label>
                    <input type="text" name="specialization" class="form-control @error('specialization') is-invalid @enderror" id="specialization" placeholder="Contoh: Matematika, Fisika" value="{{ old('specialization') }}">
                     @error('specialization')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('tutors.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop