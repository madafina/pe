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
            <div class="form-group row">
                <label for="course_filter" class="col-sm-2 col-form-label">Filter Program:</label>
                <div class="col-sm-4">
                    <select id="course_filter" class="form-control">
                        <option value="">-- Tampilkan Semua --</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
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
        $('#course_filter').on('change', function() {
            // Gunakan cara yang lebih spesifik untuk Yajra
            window.LaravelDataTables["student-table"].ajax.reload();
        });
    </script>
@stop