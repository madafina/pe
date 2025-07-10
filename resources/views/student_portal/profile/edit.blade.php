@extends('adminlte::page')
@section('title', 'Edit Profil Saya')
@section('content_header')
    <h1>Edit Profil Saya</h1>
@stop

@section('content')
    <form action="{{ route('student.profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Data Diri</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Email (Tidak dapat diubah)</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" value="{{ $user->name }}" >
                </div>
                <div class="form-group">
                    <label for="parent_phone_number">No. HP Orang Tua</label>
                    <input type="text" name="parent_phone_number" id="parent_phone_number" class="form-control" value="{{ old('parent_phone_number', $user->student->parent_phone_number) }}" required>
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea name="address" id="address" class="form-control">{{ old('address', $user->student->address) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="school_origin">Sekolah Asal</label>
                    <input type="text" name="school_origin" id="school_origin" class="form-control" value="{{ old('school_origin', $user->student->school_origin) }}">
                </div>
            </div>
        </div>

        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Ubah Password</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">Kosongkan jika tidak ingin mengubah password.</p>
                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>
            </div>
        </div>

        <div class="my-3">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
@stop