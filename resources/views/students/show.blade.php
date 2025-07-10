@extends('adminlte::page')

@section('title', 'Detail Siswa')

@section('content_header')
    <h1>Detail Siswa: {{ $student->full_name }} <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm ml-1">Edit</a></h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            {{-- KARTU PROFIL SISWA --}}
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <h3 class="profile-username text-center">{{ $student->full_name }} </h3>
                    <p class="text-muted text-center">Siswa</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>No. HP Orang Tua</b> <a class="float-right">{{ $student->parent_phone_number }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Email</b> <a class="float-right">{{ $student->user->email}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Tingkat</b> <a class="float-right">{{ $student->education_level ?? '-' }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Sekolah Asal</b> <a class="float-right">{{ $student->school_origin ?? '-' }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Tgl. Daftar</b> <a
                                class="float-right">{{ \Carbon\Carbon::parse($student->registration_date)->format('d M Y') }}</a>
                        </li>
                    </ul>
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                    <p class="text-muted">{{ $student->address ?? 'Tidak ada data.' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            {{-- KARTU PROGRAM & KEUANGAN --}}
            <div class="card">
               
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="registration">
                            @if ($student->registration)
                                <h5><strong>Program yang Diambil</strong></h5>
                                 <h1 class="badge badge-warning mb-2">
                                    {{ $student->registration->coursePrice->course->name }}                                    
                                 </h1>
                               <p>Biaya: Rp
                                        {{ number_format($student->registration->coursePrice->price, 0, ',', '.') }}</p>
                                <hr>
                                <h5><strong>Riwayat Tagihan (Invoice)</strong></h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No. Invoice</th>
                                            <th>Deskripsi</th>
                                            <th>Jumlah</th>
                                            <th>Jatuh Tempo</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($student->registration->invoices as $invoice)
                                            <tr>
                                                <td>{{ $invoice->invoice_number }}</td>
                                                <td>{{ $invoice->description }}</td>
                                                <td>Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</td>
                                                <td>
                                                    <span
                                                        class="badge @if ($invoice->status == 'Paid') badge-success @else badge-warning @endif">
                                                        {{ $invoice->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Belum ada riwayat tagihan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            @else
                                <p class="text-center">Siswa ini belum memiliki data pendaftaran.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('students.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Siswa</a>
@stop
