@extends('adminlte::page')

@section('title', 'Log Pembayaran')

@section('content_header')
    <h1>Log Semua Pembayaran</h1>
@stop

@section('content')
    <div class="card">

        <div class="card-header">
            <h3 class="card-title">Daftar Semua Transaksi Pembayaran yang Diterima</h3>
            <div class="card-tools">
                <a href="{{ route('payments.trash') }}" class="btn btn-warning btn-sm">Lihat Arsip</a>
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
        // Gunakan event delegation pada dokumen untuk memastikan listener selalu aktif
        $(document).on('click', '.delete-btn', function() {
            var paymentId = $(this).data('id');
            var url = "{{ route('payments.destroy', ':id') }}".replace(':id', paymentId);

            Swal.fire({
                title: 'Anda yakin?',
                text: "Data pembayaran ini akan dihapus (soft delete).",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Dihapus!', response.message, 'success');
                                // Gunakan cara reload yang lebih pasti
                                window.LaravelDataTables["payment-table"].ajax.reload();
                            } else {
                                Swal.fire('Gagal!', response.message || 'Terjadi kesalahan.',
                                    'error');
                            }
                        },
                        // Tambahkan blok error untuk debugging
                        error: function(xhr) {
                            Swal.fire('Error!',
                                'Tidak dapat memproses permintaan. Silakan cek console.',
                                'error');
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        });

        // Script untuk konfirmasi kirim ulang notifikasi
        $(document).on('submit', '.resend-form', function(e) {
            e.preventDefault();
            var form = this;
            Swal.fire({
                title: 'Anda yakin?',
                text: "Notifikasi pembayaran akan dikirim ulang ke wali siswa.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kirim Ulang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@stop
