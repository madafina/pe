@extends('adminlte::page')
@section('title', 'Edit Mata Pelajaran')
@section('content_header')
    <h1>Edit Mata Pelajaran: {{ $subject->name }}</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                 <div class="form-group">
                    <label for="name">Nama Mata Pelajaran</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $subject->name) }}" required>
                </div>
                <div class="form-group">
                    <label>Program / Tingkat</label>
                    <select name="course_id" class="form-control" required>
                        <option value="" disabled>-- Pilih Program --</option>
                        @foreach($courses as $course)
                            {{-- PERBAIKAN DI SINI: --}}
                            {{-- Kita gunakan old() untuk menangani validation error, dan $subject->course_id untuk data awal --}}
                            <option value="{{ $course->id }}" {{ old('course_id', $subject->course_id) == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi (Opsional)</label>
                    <textarea name="description" class="form-control">{{ old('description', $subject->description) }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop