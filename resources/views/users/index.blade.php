@extends('adminlte::page')

@section('title', 'Manajemen Pengguna')

@section('content_header')
    <h1>Manajemen Pengguna</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Semua Pengguna Sistem</h3>
            <div class="card-tools">
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">+ Tambah User Baru</a>
            </div>
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
@stop

@section('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        // Script untuk notifikasi setelah berhasil tambah/update data
        @if(session('success'))
            Swal.fire({
                type: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif

        // SCRIPT UNTUK AKSI HAPUS (SOFT DELETE)
        $('#user-table').on('click', '.delete-btn', function() {
            var userId = $(this).data('id');
            var url = "{{ route('users.destroy', ':id') }}".replace(':id', userId);
            
            Swal.fire({
                title: 'Anda yakin?',
                text: "User ini akan dinonaktifkan (soft delete)!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: { "_token": "{{ csrf_token() }}" },
                        success: function(response) {
                            if(response.success) {
                                Swal.fire('Dihapus!', response.message, 'success');
                                $('#user-table').DataTable().ajax.reload();
                            } else {
                                Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Gagal!', 'Tidak dapat menghapus user ini.', 'error');
                        }
                    });
                }
            });
        });
    </script>
@stop