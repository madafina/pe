@extends('adminlte::page')
@section('title', 'Ambil Presensi')
@section('content_header')
    <h1>Ambil Presensi Kelas: {{ $studyClass->name }}</h1>
    <p>Jadwal: {{ $studyClass->day_of_week }}, {{ \Carbon\Carbon::parse($studyClass->start_time)->format('H:i') }}</p>
@stop

@section('content')
    <form action="{{ route('attendances.store', $studyClass->id) }}" method="POST">
        @csrf
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Formulir Presensi</h3>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="attendance_date" class="col-sm-2 col-form-label">Tanggal Pertemuan</label>
                    <div class="col-sm-4">
                        <input type="date" name="attendance_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <hr>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th width="40%">Status Kehadiran</th>
                            <th width="30%">Catatan (Opsional)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($studyClass->students as $student)
                            <tr>
                                <td>{{ $student->full_name }}</td>
                                <td>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="attendances[{{ $student->id }}][status]" value="Hadir" checked> Hadir
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="attendances[{{ $student->id }}][status]" value="Izin"> Izin
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="attendances[{{ $student->id }}][status]" value="Sakit"> Sakit
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="attendances[{{ $student->id }}][status]" value="Alpa"> Alpa
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="attendances[{{ $student->id }}][notes]" class="form-control form-control-sm" placeholder="Catatan...">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Presensi</button>
                <a href="{{ route('study-classes.show', $studyClass->id) }}" class="btn btn-secondary">Batal</a>
            </div>
        </div>
    </form>
@stop