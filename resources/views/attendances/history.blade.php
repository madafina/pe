@extends('adminlte::page')
@section('title', 'Riwayat Presensi')
@section('content_header')
    <h1>Riwayat Presensi: {{ $studyClass->name }}</h1>
@stop

@section('content')
    {{-- HAPUS FORM FILTER --}}

    {{-- TABEL PIVOT RIWAYAT --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Rekapitulasi Kehadiran</h3>
        </div>
        <div class="card-body table-responsive p-0">
            @if(count($studentsInClass) > 0 && count($dateColumns) > 0)
                <table class="table table-bordered table-hover text-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th class="text-left align-middle">Nama Siswa</th>
                            @foreach($dateColumns as $date)
                                <th>{{ \Carbon\Carbon::parse($date)->format('d/m') }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($studentsInClass as $student)
                            <tr>
                                <td>{{ $student->full_name }}</td>
                                @foreach($dateColumns as $date)
                                    @php
                                        // Buat kunci untuk mencari data presensi
                                        $key = $student->id . '_' . $date;
                                        $record = $attendances->get($key);

                                        // Tentukan status dan warna badge
                                        $status = $record ? $record->status : '-';
                                        $badgeClass = '';
                                        switch($status) {
                                            case 'Hadir': $badgeClass = 'badge-success'; break;
                                            case 'Izin': $badgeClass = 'badge-info'; break;
                                            case 'Sakit': $badgeClass = 'badge-warning'; break;
                                            case 'Alpa': $badgeClass = 'badge-danger'; break;
                                            default: $badgeClass = 'badge-light text-muted';
                                        }
                                    @endphp
                                    <td class="text-center" title="{{ $status }}">
                                        {{-- Tampilkan hanya huruf pertama untuk ringkas --}}
                                        <span class="badge {{ $badgeClass }}">{{ substr($status, 0, 1) }}</span>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                 <div class="alert alert-warning text-center m-3">
                   Tidak ada data presensi yang tercatat untuk kelas ini.
               </div>
            @endif
        </div>
    </div>
    <div class="mt-2">
        <strong>Keterangan:</strong>
        <span class="badge badge-success">H</span>: Hadir,
        <span class="badge badge-info">I</span>: Izin,
        <span class="badge badge-warning">S</span>: Sakit,
        <span class="badge badge-danger">A</span>: Alpa
    </div>
@stop