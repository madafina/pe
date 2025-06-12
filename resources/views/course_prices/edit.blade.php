@extends('adminlte::page')
@section('title', 'Edit Paket Harga')
@section('content_header')
    <h1>Edit Paket Harga</h1>
@stop
@section('content')
    <div class="card card-primary">
        <form action="{{ route('course-prices.update', $coursePrice->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Program</label>
                    <select name="course_id" class="form-control" required>
                         @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id', $coursePrice->course_id) == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Nama Paket</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $coursePrice->name) }}" required>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $coursePrice->price) }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                         <div class="form-group">
                            <label>Pendaftaran Dibuka</label>
                            <input type="date" name="registration_open_date" class="form-control" value="{{ old('registration_open_date', $coursePrice->registration_open_date) }}" required>
                       </div>
                   </div>
                    <div class="col-md-6">
                        <div class="form-group">
                           <label>Pendaftaran Ditutup</label>
                           <input type="date" name="registration_close_date" class="form-control" value="{{ old('registration_close_date', $coursePrice->registration_close_date) }}" required>
                       </div>
                   </div>
                </div>
                 <div class="form-group">
                   <label>Jatuh Tempo Pembayaran</label>
                   <input type="date" name="payment_deadline" class="form-control" value="{{ old('payment_deadline', $coursePrice->payment_deadline) }}" required>
               </div>
               <div class="form-group">
                   <label>Catatan Pembayaran</label>
                   <input type="text" name="payment_notes" class="form-control" value="{{ old('payment_notes', $coursePrice->payment_notes) }}" required>
               </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('course-prices.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop