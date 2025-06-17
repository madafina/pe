@extends('adminlte::page')
@section('title', 'Edit Kategori')
@section('content_header')
    <h1>Edit Kategori Pengeluaran</h1>
@stop
@section('content')
    <div class="card card-primary">
        <form action="{{ route('expense-categories.update', $expenseCategory->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $expenseCategory->name) }}" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control">{{ old('description', $expenseCategory->description) }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('expense-categories.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop