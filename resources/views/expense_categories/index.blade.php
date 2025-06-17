@extends('adminlte::page')
@section('title', 'Kategori Pengeluaran')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Kategori Pengeluaran</h3>
            <div class="card-tools"><a href="{{ route('expense-categories.create') }}" class="btn btn-primary btn-sm">+ Tambah Kategori</a></div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Nama Kategori</th><th>Deskripsi</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td><a href="{{ route('expense-categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
@section('js')
    @if(session('success'))<script>Swal.fire('Berhasil!', '{{ session('success') }}', 'success');</script>@endif
@stop