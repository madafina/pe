@extends('adminlte::page')

@section('title', 'Data Siswa')

@section('content_header')
    <h1>Data Siswa Terdaftar</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Semua Siswa</h3>
        </div>
        <div class="card-body">
            {{-- AREA FILTER --}}
            {{-- <div class="form-group row">
                <label for="course_filter" class="col-sm-2 col-form-label">Filter Program:</label>
                <div class="col-sm-4">
                    <select id="course_filter" class="form-control">
                        <option value="">-- Tampilkan Semua --</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div> --}}

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="course_filter" class="col-sm-4 col-form-label">Filter Program:</label>
                        <div class="col-sm-8">
                            <select id="course_filter" class="form-control">
                                <option value="">-- Tampilkan Semua --</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="status_filter" class="col-sm-4 col-form-label">Filter Status Siswa:</label>
                        <div class="col-sm-8">
                            <select id="status_filter" class="form-control">
                                <option value="">-- Tampilkan Semua --</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Non-Aktif">Non-Aktif</option>
                                <option value="Lulus">Lulus</option>
                                <option value="Berhenti">Berhenti</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            {{-- DataTable akan dirender di sini --}}
            <div class="overflow-x-auto">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@stop

@section('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        // Script untuk memicu reload datatable saat filter diubah
        $('#course_filter, #status_filter').on('change', function() {
            $('#student-table').DataTable().ajax.reload();
        });
    </script>
@stop
