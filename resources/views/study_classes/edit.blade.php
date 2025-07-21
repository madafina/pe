@extends('adminlte::page')
@section('title', 'Edit Kelas')
@section('content_header')
    <h1>Edit Kelas: {{ $studyClass->name }}</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('study-classes.update', $studyClass->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Kelas</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $studyClass->name) }}" required>
                </div>
                {{-- PERBAIKAN STRUKTUR HTML DI SINI --}}
                <div class="row"> 
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <label>Mata Pelajaran</label>
                            <select name="subject_id" class="form-control" required>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ $studyClass->subject_id == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tutor Pengajar</label>
                            <select name="tutor_id" class="form-control" required>
                                 @foreach($tutors as $tutor)
                                    <option value="{{ $tutor->id }}" {{ $studyClass->tutor_id == $tutor->id ? 'selected' : '' }}>
                                        {{ $tutor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                         <div class="form-group">
                            <label>Hari</label>
                            <select name="day_of_week" class="form-control" required>
                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                    <option {{ $studyClass->day_of_week == $day ? 'selected' : '' }}>{{ $day }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jam Mulai:</label>
                            <input type="time" name="start_time" class="form-control" value="{{ old('start_time', \Carbon\Carbon::parse($studyClass->start_time)->format('H:i')) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jam Selesai:</label>
                            <input type="time" name="end_time" class="form-control" value="{{ old('end_time', \Carbon\Carbon::parse($studyClass->end_time)->format('H:i')) }}" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('study-classes.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop