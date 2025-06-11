@extends('adminlte::page')
@section('title', 'Tambah Mata Pelajaran')
@section('content_header')
    <h1>Tambah Mata Pelajaran Baru</h1>
@stop
@section('content')
    <div class="card card-primary">
        <form action="{{ route('subjects.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Mata Pelajaran</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label>Program / Tingkat</label>
                    <select name="course_id" class="form-control" required>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi (Opsional)</label>
                    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop
