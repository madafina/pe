@extends('adminlte::page')
@section('title', 'Tagihan Saya')
@section('content_header')
    <h1>Tagihan Saya</h1>
@stop

@section('content')
    @forelse($invoices as $invoice)
        {{-- <div class="card">
            <div class="card-header">
                <h3 class="card-title"><strong>No. Invoice: {{ $invoice->invoice_number }}</strong></h3>
                <div class="card-tools">
                    @php
                        $status = $invoice->getCalculatedStatusAttribute();
                        $badge_class = 'badge-secondary';
                        if ($status == 'Paid') {
                            $badge_class = 'badge-success';
                        }
                        if ($status == 'Partially Paid') {
                            $badge_class = 'badge-info';
                        }
                        if ($status == 'Unpaid') {
                            $badge_class = 'badge-warning';
                        }
                        if ($status == 'Overdue') {
                            $badge_class = 'badge-danger';
                        }
                    @endphp
                    <span class="badge {{ $badge_class }}">{{ $status }}</span>
                </div>
            </div>
            <div class="card-body">
                <p><strong>Deskripsi:</strong> {{ $invoice->description }}</p>
                <p><strong>Jumlah Tagihan:</strong> Rp {{ number_format($invoice->amount, 0, ',', '.') }}</p>
                <p><strong>Sisa Tagihan:</strong> Rp {{ number_format($invoice->remaining_amount, 0, ',', '.') }}</p>
                <p><strong>Jatuh Tempo:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('d F Y') }}</p>

         
                @if ($invoice->getCalculatedStatusAttribute() != 'Paid')
                    <button class="btn btn-success mt-3" data-toggle="modal" data-target="#uploadModal-{{ $invoice->id }}"
                        data-total-amount="{{ $invoice->amount }}" data-remaining-amount="{{ $invoice->remaining_amount }}">
                        <i class="fas fa-upload"></i> Unggah Bukti Bayar
                    </button>
                @endif

                @if ($invoice->paymentSubmissions->count() > 0)
                    <hr>
                    <h5>Riwayat Pengajuan Pembayaran:</h5>
                    <ul class="list-group list-group-flush">
                        @foreach ($invoice->paymentSubmissions as $submission)
                            <li class="list-group-item">
                                {{ $submission->created_at->format('d M Y') }} - Rp
                                {{ number_format($submission->amount) }}
                                <span
                                    class="badge {{ $submission->status == 'approved' ? 'badge-success' : ($submission->status == 'rejected' ? 'badge-danger' : 'badge-warning') }}">
                                    {{ ucfirst($submission->status) }}
                                </span>
                          
                                @if ($submission->status == 'rejected')
                                    <p class="text-danger mb-0 mt-1"><small><strong>Alasan Ditolak:</strong>
                                            {{ $submission->rejection_reason }}</small></p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="card-footer">
               <i class="fas fa-exclamation-triangle"></i> Silakan lakukan pembayaran dan konfirmasi ke bagian administrasi.
            </div>
        </div> --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><strong>No. Invoice: {{ $invoice->invoice_number }}</strong></h3>
                <div class="card-tools">
                    @php
                        $status = $invoice->getCalculatedStatusAttribute();
                        $badge_class = 'badge-secondary';
                        if ($status == 'Paid') {
                            $badge_class = 'badge-success';
                        }
                        if ($status == 'Partially Paid') {
                            $badge_class = 'badge-info';
                        }
                        if ($status == 'Unpaid') {
                            $badge_class = 'badge-warning';
                        }
                        if ($status == 'Overdue') {
                            $badge_class = 'badge-danger';
                        }
                    @endphp
                    <span class="badge {{ $badge_class }}">{{ $status }}</span>
                </div>
            </div>
            <div class="card-body">
                <p><strong>Deskripsi:</strong> {{ $invoice->description }}</p>
                <p><strong>Jumlah Tagihan:</strong> Rp {{ number_format($invoice->amount, 0, ',', '.') }}</p>
                <p><strong>Sisa Tagihan:</strong> <span class="text-danger font-weight-bold">Rp
                        {{ number_format($invoice->remaining_amount, 0, ',', '.') }}</span></p>
                <p><strong>Jatuh Tempo:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('d F Y') }}</p>

                {{-- Tombol Aksi --}}
                @if ($invoice->getCalculatedStatusAttribute() != 'Paid')
                    <button class="btn btn-success mt-2" data-toggle="modal" data-target="#uploadModal-{{ $invoice->id }}"
                        data-total-amount="{{ $invoice->amount }}" data-remaining-amount="{{ $invoice->remaining_amount }}">
                        <i class="fas fa-upload"></i> Unggah Bukti Bayar
                    </button>
                @endif

                <hr>

                {{-- BAGIAN BARU: RIWAYAT PEMBAYARAN DITERIMA --}}
                <h5><i class="fas fa-history"></i> Riwayat Pembayaran Diterima</h5>
                @if ($invoice->payments->count() > 0)
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Tgl. Verifikasi</th>
                                <th>Jumlah Dibayar</th>
                                <th>Diverifikasi Oleh</th>
                                <th>Aksi</th> {{-- Ubah dari Bukti --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice->payments as $payment)
                                <tr>
                                    <td>{{ $payment->created_at->format('d M Y') }}</td>
                                    <td>Rp {{ number_format($payment->amount_paid, 0, ',', '.') }}</td>
                                    <td>{{ $payment->verifier->name ?? 'Sistem' }}</td>
                                    <td>
                                        {{-- Tambahkan tombol kuitansi --}}
                                        <a href="{{ route('public.receipt.show', $payment->uuid) }}" target="_blank"
                                            class="btn btn-xs btn-primary">Lihat Kuitansi</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">Belum ada pembayaran yang diterima untuk tagihan ini.</p>
                @endif

                {{-- Riwayat Pengajuan Pembayaran --}}
                @if ($invoice->paymentSubmissions->count() > 0)
                    <h5 class="mt-4"><i class="fas fa-paper-plane"></i> Riwayat Pengajuan Pembayaran</h5>
                    <ul class="list-group list-group-flush">
                        @foreach ($invoice->paymentSubmissions as $submission)
                            <li class="list-group-item">
                                {{ $submission->created_at->format('d M Y') }} - Mengajukan Rp
                                {{ number_format($submission->amount) }}
                                <span
                                    class="badge {{ $submission->status == 'approved' ? 'badge-success' : ($submission->status == 'rejected' ? 'badge-danger' : 'badge-warning') }}">
                                    {{ ucfirst($submission->status) }}
                                </span>
                                @if ($submission->status == 'rejected')
                                    <p class="text-danger mb-0 mt-1"><small><strong>Alasan:</strong>
                                            {{ $submission->rejection_reason }}</small></p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>


        {{-- Modal untuk setiap invoice --}}
        <div class="modal fade" id="uploadModal-{{ $invoice->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('student.payment_submissions.store', $invoice->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Unggah Pembayaran untuk Invoice {{ $invoice->invoice_number }}</h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="amount">Jumlah Dibayar</label>
                                <input type="number" name="amount" class="form-control amount-input" required>
                                <small class="form-text text-muted">
                                    Maks: <span class="max-amount"></span>
                                </small>
                            </div>
                            <div class="form-group"><label>Bukti Pembayaran (JPG/PNG)</label>
                                <div class="custom-file"><input type="file" name="proof_path" class="custom-file-input"
                                        required><label class="custom-file-label">Pilih file...</label></div>
                            </div>
                            <div class="form-group"><label>Catatan (Opsional)</label>
                                <textarea name="notes" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer"><button type="submit" class="btn btn-primary">Kirim</button></div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">Anda belum memiliki tagihan.</div>
    @endforelse
@stop

@section('js')
    @if (session('success'))
        <script>
            Swal.fire('Berhasil!', '{{ session('success') }}', 'success');
        </script>
    @endif
    <script>
        // Script untuk custom file input
        $('.custom-file-input').on('change', function(event) {
            var inputFile = event.currentTarget;
            // Ambil label yang berhubungan dengan input ini
            $(inputFile).parent()
                .find('.custom-file-label')
                .html(inputFile.files[0].name);
        });

        // Script untuk mengatur min/max pada modal saat dibuka
        $('[data-toggle="modal"]').on('click', function() {
            const button = $(this);
            const totalAmount = button.data('total-amount');
            const remainingAmount = button.data('remaining-amount');
            const minAmount = totalAmount * 0.5;

            const targetModalId = button.data('target');
            const modal = $(targetModalId);

            modal.find('.amount-input').attr('max', remainingAmount);
            //modal.find('.min-amount').text('Rp ' + new Intl.NumberFormat('id-ID').format(minAmount));
            modal.find('.max-amount').text('Rp ' + new Intl.NumberFormat('id-ID').format(remainingAmount));
        });
    </script>

    <script>
        // Script untuk menampilkan nama file di input custom file
        $('.custom-file-input').on('change', function(event) {
            var inputFile = event.currentTarget;
            $(inputFile).parent()
                .find('.custom-file-label')
                .html(inputFile.files[0].name);
        });
    </script>


@stop
