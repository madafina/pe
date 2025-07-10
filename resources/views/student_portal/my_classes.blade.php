@extends('adminlte::page')

@section('title', 'Kelas Saya')

@section('content_header')
    <h1>Kelas yang Saya Ikuti</h1>
@stop

@section('content')
    <div class="row">
        @forelse($studyClasses as $class)
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title"><strong>{{ $class->name }}</strong></h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <strong>Mata Pelajaran:</strong> {{ $class->subject->name }}<br>
                            <strong>Tutor:</strong> {{ $class->tutor->name }}<br>
                            <strong>Jadwal:</strong> {{ $class->day_of_week }}, {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($class->end_time)->format('H:i') }}
                        </p>
                       <a href="{{ route('student.my_classes.show', $class->id) }}" class="btn btn-primary">Lihat Detail Kelas</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">
                    <p>Anda belum terdaftar di kelas mana pun. Silakan hubungi bagian administrasi.</p>
                </div>
            </div>
        @endforelse
    </div>
@stop
