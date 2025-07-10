@extends('adminlte::page')
@section('title', 'Arsip Log Pembayaran')
@section('content_header')
    <h1>Arsip Log Pembayaran</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Pembayaran yang Telah Dihapus</h3>
            <div class="card-tools">
                <a href="{{ route('payments.index') }}" class="btn btn-primary btn-sm">Kembali ke Log Utama</a>
            </div>
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
@stop
@section('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @if(session('success'))
    <script> Swal.fire('Berhasil!', '{{ session('success') }}', 'success'); </script>
    @endif
@stop