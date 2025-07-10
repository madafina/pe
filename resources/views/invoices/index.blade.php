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

            {{-- AREA FILTER --}}
            <div class="form-group row">
                <label for="status_filter" class="col-sm-2 col-form-label">Filter Status:</label>
                <div class="col-sm-4">
                    <select id="status_filter" class="form-control">
                        <option value="">-- Tampilkan Semua --</option>
                        <option value="Unpaid">Belum Dibayar</option>
                        <option value="Partially Paid">Dibayar Sebagian (Cicilan)</option>
                        <option value="Paid">Lunas</option>
                        <option value="Overdue">Jatuh Tempo</option>
                    </select>
                </div>
            </div>

            <hr>

            {{ $dataTable->table() }}
        </div>
    </div>

    <!-- Modal Catat Pembayaran -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Catat Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="paymentForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="amount_paid">Jumlah Bayar (Maks: <span id="maxAmount"></span>)</label>
                            <input type="number" class="form-control" id="amount_paid" name="amount_paid" required>
                        </div>
                        <div class="form-group">
                            <label for="payment_date">Tanggal Bayar</label>
                            <input type="date" class="form-control" id="payment_date" name="payment_date"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="proof_of_payment">Unggah Bukti Bayar (Opsional)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="proof_of_payment"
                                    name="proof_of_payment" required>
                                <label class="custom-file-label" for="proof_of_payment">Pilih file...</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="notes">Catatan (Opsional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    {{-- Load script dari DataTables --}}
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>       

        $(document).on('click', '.record-payment-btn', function() {
            let invoiceId = $(this).data('id');
            let remainingAmount = $(this).data('remaining');
            let url = "{{ route('payments.store', ':id') }}".replace(':id', invoiceId);

            $('#paymentForm').attr('action', url);
            $('#maxAmount').text('Rp ' + new Intl.NumberFormat('id-ID').format(remainingAmount));
            $('#amount_paid').attr('max', remainingAmount);
            $('#paymentModal').modal('show');
        });

        $('#paymentForm').on('submit', function(e) {
            e.preventDefault();
            let form = this;
            let url = $(form).attr('action');
            let formData = new FormData(form);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#paymentModal').modal('hide');
                    $(form).trigger("reset");
                    Swal.fire('Berhasil!', response.message, 'success');

                    // GANTI BARIS INI
                    $('#invoice-table').DataTable().ajax.reload(null, false);
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMsg = '';
                    $.each(errors, function(key, value) {
                        errorMsg += value[0] + '\n';
                    });
                    Swal.fire('Gagal!', errorMsg, 'error');
                }
            });
        });

        // Script untuk memicu reload datatable saat filter diubah
        $('#status_filter').on('change', function() {
            // reload 
            $('#invoice-table').DataTable().ajax.reload();
        });

        // Script untuk menampilkan nama file di input custom file
        $('.custom-file-input').on('change', function(event) {
            var inputFile = event.currentTarget;
            $(inputFile).parent()
                .find('.custom-file-label')
                .html(inputFile.files[0].name);
        });
    </script>
@stop
