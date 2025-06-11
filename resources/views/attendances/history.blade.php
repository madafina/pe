@extends('adminlte::page')
@section('title', 'Riwayat Presensi')
@section('content_header')
    <h1>Riwayat Presensi: {{ $studyClass->name }}</h1>
@stop

@section('content')
    {{-- FORM FILTER --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filter Riwayat</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('attendances.history', $studyClass->id) }}">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Dari Tanggal:</label>
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date', now()->subMonths(1)->toDateString()) }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                         <div class="form-group">
                            <label>Sampai Tanggal:</label>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date', now()->toDateString()) }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- HASIL RIWAYAT --}}
    @forelse($attendances as $date => $records)
        <div class="card">
            <div class="card-header bg-lightblue">
                <h3 class="card-title"><strong>Tanggal: {{ \Carbon\Carbon::parse($date)->format('d F Y') }}</strong></h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Status Kehadiran</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $record)
                        <tr>
                            <td>{{ $record->student->full_name ?? 'Siswa tidak ditemukan' }}</td>
                            <td>
                                 <span class="badge 
                                    @if($record->status == 'Hadir') badge-success 
                                    @elseif($record->status == 'Izin') badge-info
                                    @elseif($record->status == 'Sakit') badge-warning
                                    @else badge-danger @endif">
                                    {{ $record->status }}
                                </span>
                            </td>
                            <td>{{ $record->notes ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="alert alert-warning text-center">
            Tidak ada data presensi pada rentang tanggal yang dipilih.
        </div>
    @endforelse
@stop