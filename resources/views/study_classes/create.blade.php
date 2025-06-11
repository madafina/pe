@extends('adminlte::page')
@section('title', 'Buat Kelas Baru')
@section('content_header')
    <h1>Buat Kelas Baru</h1>
@stop
@section('content')
    <div class="card card-primary">
        <form action="{{ route('study-classes.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Kelas</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Fisika 11A - Sore" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mata Pelajaran</label>
                            <select name="subject_id" class="form-control" required>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tutor Pengajar</label>
                            <select name="tutor_id" class="form-control" required>
                                 @foreach($tutors as $tutor)
                                    <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
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
                                <option>Senin</option><option>Selasa</option><option>Rabu</option><option>Kamis</option><option>Jumat</option><option>Sabtu</option><option>Minggu</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jam Mulai:</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jam Selesai:</label>
                            <input type="time" name="end_time" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('study-classes.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop
