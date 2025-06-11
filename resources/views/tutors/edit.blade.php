@extends('adminlte::page')

@section('title', 'Edit Tutor')

@section('content_header')
    <h1>Edit Data Tutor</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Formulir Edit Tutor</h3>
        </div>
        {{-- Ubah action ke route update dan tambahkan method PUT --}}
        <form action="{{ route('tutors.update', $tutor->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Tutor</label>
                    {{-- Isi value dengan data dari $tutor --}}
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $tutor->name) }}" required>
                    @error('name') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                </div>

                <div class="form-group">
                    <label for="phone_number">No. Telepon</label>
                    <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" value="{{ old('phone_number', $tutor->phone_number) }}">
                    @error('phone_number') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                </div>

                <div class="form-group">
                    <label for="specialization">Spesialisasi</label>
                    <input type="text" name="specialization" class="form-control @error('specialization') is-invalid @enderror" id="specialization" value="{{ old('specialization', $tutor->specialization) }}">
                     @error('specialization') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                </div>
                 <div class="form-group">
                    <label for="is_active">Status</label>
                    <select name="is_active" id="is_active" class="form-control">
                        <option value="1" {{ old('is_active', $tutor->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active', $tutor->is_active) == 0 ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('tutors.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop
