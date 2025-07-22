@extends('adminlte::page')

@section('title', 'Detail Kelas')

@section('content_header')
    {{-- Header dinamis --}}
    <h1>Detail Kelas: {{ $studyClass->name }}</h1>
    <p>
        <strong>Tutor:</strong> {{ $studyClass->tutor->name }} |
        <strong>Jadwal:</strong> {{ $studyClass->day_of_week }},
        {{ \Carbon\Carbon::parse($studyClass->start_time)->format('H:i') }} -
        {{ \Carbon\Carbon::parse($studyClass->end_time)->format('H:i') }}
    </p>
@stop

@section('content')
    <div class="row">
        {{-- KOLOM KIRI: PESERTA KELAS --}}
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Peserta Kelas Saat Ini ({{ $enrolledStudents->count() }} orang)</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <tbody>
                            @forelse($enrolledStudents as $student)
                                <tr>
                                    <td>{{ $student->full_name }}</td>
                                    <td class="text-right">
                                        {{-- Form untuk mengeluarkan siswa --}}
                                        <form
                                            action="{{ route('study-classes.removeStudent', ['studyClass' => $studyClass->id, 'student' => $student->id]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs">Keluarkan</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>Belum ada siswa di kelas ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: TAMBAH SISWA --}}
        <div class="col-md-6">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Tambah Siswa ke Kelas</h3>
                </div>
                {{-- Form untuk memasukkan siswa --}}
                <form action="{{ route('study-classes.addStudent', $studyClass->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Pilih Siswa Aktif</label>
                            <select name="student_id" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Siswa --</option>
                                @foreach ($availableStudents as $student)
                                    <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Masukkan ke Kelas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <a href="{{ route('study-classes.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Kelas</a>
    <a href="{{ route('attendances.create', $studyClass->id) }}" class="btn btn-success mt-3">Ambil Presensi Hari Ini</a>
    <a href="{{ route('attendances.history', $studyClass->id) }}" class="btn btn-info mt-3">Lihat Riwayat Presensi</a>


@stop

@section('js')
    @if (session('success'))
        <script>
            Swal.fire({
                type: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
@stop
