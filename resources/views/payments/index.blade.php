@extends('adminlte::page')

@section('title', 'Log Pembayaran')

@section('content_header')
    <h1>Log Semua Pembayaran</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Semua Transaksi Pembayaran yang Diterima</h3>
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
@stop

@section('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@stop
