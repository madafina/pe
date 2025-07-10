@extends('adminlte::page')

@section('title', 'Dasbor Siswa')

@section('content_header')
    <h1>Halo, <strong style="text-transform:capitalize;">{{ $user->name }}!</strong></h1>
@stop

@section('content')
    {{-- Pesan Selamat Datang --}}
    <div class="alert alert-info">
        <h4><i class="icon fas fa-user-check"></i> Selamat Datang Kembali!</h4>
        <p>Halo, <strong>{{ $user->name }}</strong>! Ini adalah halaman portal pribadimu.</p>
    </div>

    {{-- Kartu Profil Siswa --}}
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Profil Saya</h3>
                </div>
                <div class="card-body">
                    {{-- PERBAIKAN DI SINI: Cek jika data siswa ada --}}
                    @if($user->student)
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 30%">Nama Lengkap</th>
                                    <td>{{ $user->student->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Email Akun</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Tingkat Pendidikan</th>
                                    <td>
                                        <span class="badge badge-success">{{ $user->student->education_level ?? '-' }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>No. HP Orang Tua</th>
                                    <td>{{ $user->student->parent_phone_number ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $user->student->address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Asal Sekolah</th>
                                    <td>{{ $user->student->school_origin ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status Siswa</th>
                                    <td>
                                        @php
                                            $status = $user->student->status ?? 'Non-Aktif';
                                            $badgeClass = $status == 'Aktif' ? 'badge-success' : 'badge-warning';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        {{-- Tampilkan pesan jika data siswa tidak ada --}}
                        <div class="alert alert-warning">
                            <p>Data profil kesiswaan Anda tidak ditemukan. Silakan hubungi bagian administrasi.</p>
                        </div>
                    @endif
                </div>
                @if($user->student)
                    <div class="card-footer">
                        <a href="{{ route('student.profile.edit') }}" class="btn btn-primary">Edit Profil</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
