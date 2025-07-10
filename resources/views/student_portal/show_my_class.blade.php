@extends('adminlte::page')

@section('title', 'Detail Kelas')

@section('content_header')
    <h1>Detail Kelas: {{ $studyClass->name }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            {{-- KARTU RIWAYAT PRESENSI --}}
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Presensi Saya</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal Pertemuan</th>
                                <th>Status Kehadiran</th>
                                <th>Catatan dari Tutor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $attendance)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d F Y') }}</td>
                                    <td>
                                        @php
                                            $status = $attendance->status;
                                            $badgeClass = '';
                                            switch($status) {
                                                case 'Hadir': $badgeClass = 'badge-success'; break;
                                                case 'Izin': $badgeClass = 'badge-info'; break;
                                                case 'Sakit': $badgeClass = 'badge-warning'; break;
                                                case 'Alpa': $badgeClass = 'badge-danger'; break;
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                    </td>
                                    <td>{{ $attendance->notes ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada riwayat presensi untuk Anda di kelas ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            {{-- KARTU INFO KELAS & TEMAN SEKELAS --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Kelas</h3>
                </div>
                <div class="card-body">
                    <strong><i class="fas fa-book mr-1"></i> Mata Pelajaran</strong>
                    <p class="text-muted">{{ $studyClass->subject->name }}</p>
                    <hr>
                    <strong><i class="fas fa-chalkboard-teacher mr-1"></i> Tutor</strong>
                    <p class="text-muted">{{ $studyClass->tutor->name }}</p>
                    <hr>
                    <strong><i class="far fa-calendar-alt mr-1"></i> Jadwal</strong>
                    <p class="text-muted">{{ $studyClass->day_of_week }}, {{ \Carbon\Carbon::parse($studyClass->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($studyClass->end_time)->format('H:i') }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Teman Sekelas</h3>
                </div>
                <div class="card-body">
                    <ul>
                        @forelse($classmates as $classmate)
                            <li>{{ $classmate->full_name }}</li>
                        @empty
                            <li>Anda adalah peserta pertama di kelas ini!</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('student.my_classes') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Kelas</a>
@stop