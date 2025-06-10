@extends('adminlte::page')

@section('title', 'Manajemen Tagihan')

@section('content_header')
    <h1>Manajemen Tagihan (Invoice)</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Semua Tagihan</h3>
        </div>
        <div class="card-body">

            <div class="form-group row">
                <label for="status_filter" class="col-sm-2 col-form-label">Filter Status:</label>
                <div class="col-sm-4">
                    <select id="status_filter" class="form-control">
                        <option value="">-- Tampilkan Semua --</option>
                        <option value="Unpaid">Belum Lunas (Unpaid)</option>
                        <option value="Paid">Lunas (Paid)</option>
                        <option value="Overdue">Jatuh Tempo (Overdue)</option>
                    </select>
                </div>
            </div>

            {{ $dataTable->table() }}
        </div>
    </div>
@stop

@section('js')
    {{-- Load script dari DataTables --}}
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        // Dengarkan event 'click' pada tombol dengan class 'verify-btn'
        // di seluruh dokumen.
        $(document).on('click', '.verify-btn', function () {
            var invoiceId = $(this).data('id');
            var url = "{{ route('invoices.verify', ':id') }}".replace(':id', invoiceId);
            const csrfToken = '{{ csrf_token() }}';

            Swal.fire({
                title: 'Anda yakin?',
                text: "Anda akan memverifikasi pembayaran untuk invoice ini.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, verifikasi!',
                cancelButtonText: 'Batal',
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    try {
                        const response = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            }
                        });

                        if (!response.ok) {
                            const errorData = await response.json();
                            Swal.showValidationMessage(errorData.message || `Request failed: ${response.statusText}`);
                            return;
                        }

                        return await response.json();

                    } catch (error) {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                // PERBAIKAN FINAL DI SINI
                // Kita hanya perlu mengecek apakah 'result.value' ada.
                // Jika ada, artinya preConfirm berhasil dan mengembalikan data.
                if (result.value) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: result.value.message, // Ambil pesan dari hasil preConfirm
                    });
                    // Reload tabel untuk menampilkan data terbaru
                    $('#invoice-table').DataTable().ajax.reload();
                }
            })
        });

         // Script untuk memicu reload datatable saat filter diubah
        $('#status_filter').on('change', function() {
            // Gunakan cara reload yang sudah terbukti berhasil
            $('#invoice-table').DataTable().ajax.reload();
        });
        
    </script>
@stop


