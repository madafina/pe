@extends('adminlte::page')
@section('title', 'Tambah Paket Harga')
@section('content_header')
    <h1>Tambah Paket Harga Baru</h1>
@stop
@section('content')
    <div class="card card-primary">
        <form action="{{ route('course-prices.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Program</label>
                    <select name="course_id" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Program --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Nama Paket</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Gelombang 1 (Juli-Sep)" required>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                         <div class="form-group">
                            <label>Pendaftaran Dibuka</label>
                            <input type="date" name="registration_open_date" class="form-control" required>
                       </div>
                   </div>
                    <div class="col-md-6">
                        <div class="form-group">
                           <label>Pendaftaran Ditutup</label>
                           <input type="date" name="registration_close_date" class="form-control" required>
                       </div>
                   </div>
                </div>
                 <div class="form-group">
                   <label>Jatuh Tempo Pembayaran</label>
                   <input type="date" name="payment_deadline" class="form-control" required>
               </div>
               <div class="form-group">
                   <label>Catatan Pembayaran</label>
                   <input type="text" name="payment_notes" class="form-control" placeholder="Contoh: Pembayaran hingga Desember 2025" required>
               </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('course-prices.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop