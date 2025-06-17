@extends('adminlte::page')
@section('title', 'Tambah Kategori')
@section('content')
    <div class="card card-primary">
        <form action="{{ route('expense-categories.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group"><label>Nama Kategori</label><input type="text" name="name" class="form-control" required></div>
                <div class="form-group"><label>Deskripsi</label><textarea name="description" class="form-control"></textarea></div>
            </div>
            <div class="card-footer"><button type="submit" class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
@stop