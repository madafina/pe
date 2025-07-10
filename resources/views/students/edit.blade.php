@extends('adminlte::page')
@section('title', 'Edit Data Siswa')
@section('content_header')
    <h1>Edit Data Siswa: {{ $student->full_name }}</h1>
@stop

@section('content')
    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Data Akun & Siswa</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="full_name">Nama Lengkap</label>
                            <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $student->full_name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="form-group">
                            <label for="email">Email Akun</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $student->user->email ?? '') }}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="parent_phone_number">No. HP Orang Tua</label>
                            <input type="text" name="parent_phone_number" class="form-control" value="{{ old('parent_phone_number', $student->parent_phone_number) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status Siswa</label>
                            <select name="status" class="form-control" required>
                                @foreach(['Aktif', 'Non-Aktif', 'Lulus', 'Berhenti'] as $status)
                                    <option value="{{ $status }}" {{ old('status', $student->status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="education_level">Tingkat Pendidikan</label>
                             <select name="education_level" class="form-control" required>
                                @foreach(['Pra-Sekolah', 'SD', 'SMP', 'SMA', 'Lulus/Umum'] as $level)
                                    <option value="{{ $level }}" {{ old('education_level', $student->education_level) == $level ? 'selected' : '' }}>{{ $level }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="school_origin">Sekolah Asal</label>
                            <input type="text" name="school_origin" class="form-control" value="{{ old('school_origin', $student->school_origin) }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea name="address" class="form-control">{{ old('address', $student->address) }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </div>
    </form>
@stop