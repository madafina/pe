@extends('adminlte::page')
@section('title', 'Pengelolaan Harga')
@section('content_header')
    <h1>Pengelolaan Harga Bimbel</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Semua Paket Harga</h3>
            <div class="card-tools">
                <a href="{{ route('course-prices.create') }}" class="btn btn-primary btn-sm"> + Tambah Paket Harga</a>
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
    <script> Swal.fire('Berhasil!', '{{ session('success') }}', 'success'); </script>
    @endif
    <script>
        // Script untuk memicu reload datatable saat filter diubah
        $('#course_filter').on('change', function() {
            $('#courseprice-table').DataTable().ajax.reload();
        });
    </script>
@stop
