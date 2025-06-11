@extends('adminlte::page')

@section('title', 'Manajemen Tutor')

@section('content_header')
    <h1>Manajemen Tutor</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Semua Tutor</h3>
            <div class="card-tools">
                <a href="{{ route('tutors.create') }}" class="btn btn-primary btn-sm"> + Tambah Tutor Baru</a>
            </div>
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
@stop

@section('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        // Script untuk notifikasi setelah berhasil tambah data
        @if (session('success'))
            Swal.fire({
                type: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif       
    </script>
@stop
