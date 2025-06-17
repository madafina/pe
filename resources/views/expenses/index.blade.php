@extends('adminlte::page')
@section('title', 'Catat Pengeluaran')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Log Pengeluaran</h3>
            <div class="card-tools"><a href="{{ route('expenses.create') }}" class="btn btn-primary btn-sm">+ Catat Pengeluaran Baru</a></div>
        </div>
        <div class="card-body">{{ $dataTable->table() }}</div>
    </div>
@stop
@section('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @if(session('success'))<script>Swal.fire('Berhasil!', '{{ session('success') }}', 'success');</script>@endif
@stop