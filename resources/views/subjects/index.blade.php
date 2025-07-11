@extends('adminlte::page')
@section('title', 'Manajemen Mata Pelajaran')
@section('content_header')
    <h1>Manajemen Mata Pelajaran</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Semua Mata Pelajaran</h3>
            <div class="card-tools">
                <a href="{{ route('subjects.create') }}" class="btn btn-primary btn-sm"> + Tambah Mapel Baru</a>
            </div>
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

            {{ $dataTable->table() }}
        </div>
    </div>
@stop
@section('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @if(session('success'))
    <script>
        Swal.fire('Berhasil!', '{{ session('success') }}', 'success');
    </script>
    @endif
    <script>
        // Script untuk memicu reload datatable saat filter diubah
        $('#course_filter').on('change', function() {
            $('#subject-table').DataTable().ajax.reload();
        });
    </script>
@stop
