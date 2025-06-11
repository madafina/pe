@extends('adminlte::page')
@section('title', 'Manajemen Kelas')
@section('content_header')
    <h1>Manajemen Kelas & Jadwal</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Semua Kelas</h3>
            <div class="card-tools">
                <a href="{{ route('study-classes.create') }}" class="btn btn-primary btn-sm"> + Buat Kelas Baru</a>
            </div>
        </div>
        <div class="card-body">
            {{-- AREA FILTER --}}
            <div class="form-group row">
                <label for="day_filter" class="col-sm-2 col-form-label">Filter Hari:</label>
                <div class="col-sm-4">
                    <select id="day_filter" class="form-control">
                        <option value="">-- Tampilkan Semua --</option>
                        <option>Senin</option>
                        <option>Selasa</option>
                        <option>Rabu</option>
                        <option>Kamis</option>
                        <option>Jumat</option>
                        <option>Sabtu</option>
                        <option>Minggu</option>
                    </select>
                </div>
            </div>
            {{ $dataTable->table() }}
        </div>
    </div>
@stop
@section('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @if (session('success'))
        <script>
            Swal.fire('Berhasil!', '{{ session('success') }}', 'success');
        </script>
    @endif

    <script>
        // Script untuk memicu reload datatable saat filter diubah
        $('#day_filter').on('change', function() {
            $('#studyclass-table').DataTable().ajax.reload();
        });
    </script>
@stop
