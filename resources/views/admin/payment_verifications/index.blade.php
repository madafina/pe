@extends('adminlte::page')

@section('title', 'Verifikasi Pembayaran')

@section('content_header')
    <h1>Verifikasi Pembayaran Masuk</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Pengajuan Pembayaran yang Menunggu Persetujuan</h3>
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
    <!-- Modal untuk Reject -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alasan Penolakan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="rejection_reason">Tuliskan alasan penolakan:</label>
                            <textarea name="rejection_reason" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Kirim Penolakan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    {{-- Script untuk notifikasi --}}
    @if (session('success'))
        <script>
            Swal.fire('Berhasil!', '{{ session('success') }}', 'success');
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire('Gagal!', '{{ session('error') }}', 'error');
        </script>
    @endif

    <script>
        // Script untuk konfirmasi approve
        $('.approve-btn-form').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Approve Pembayaran?',
                text: "Aksi ini akan mencatat pembayaran.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Approve!',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Script untuk mengisi action form di modal reject
        $(document).on('click', '.reject-btn-modal', function() {
            const action = $(this).data('action');
            $('#rejectForm').attr('action', action);
        });
    </script>


@stop
