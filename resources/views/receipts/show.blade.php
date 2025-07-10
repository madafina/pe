<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Pembayaran {{ $payment->invoice->invoice_number }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Times New Roman', Times, serif; }
        .receipt-container { max-width: 800px; margin: 50px auto; background: white; border: 1px solid #dee2e6; padding: 40px; }
        .receipt-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
            margin-bottom: 40px;
        }
        .logo { max-width: 100px; }
        .company-details { text-align: right; }
        .company-details h2 { margin: 0; font-size: 1.5rem; font-weight: bold; }
        .receipt-title { text-align: center; margin-bottom: 40px; }
        .receipt-title h1 { margin: 0; font-size: 2.5rem; text-decoration: underline; }
        .receipt-title p { margin: 0; color: #6c757d; }
        .receipt-body table td { padding-top: 15px; padding-bottom: 15px; vertical-align: top; }
        .receipt-footer { text-align: right; margin-top: 70px; }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <div class="logo-container">
                {{-- Ganti 'bimbel.jpg' dengan path logo Oppa --}}
                <img src="{{ asset('vendor/adminlte/dist/img/logo.png') }}" alt="Logo Bimbel" class="logo">
            </div>
            <div class="company-details">
                <h2>BIMBEL PENA EMAS</h2>
                <p>Jl. Pendidikan No. 123, Kasihan, Bantul<br>
                   Daerah Istimewa Yogyakarta<br>
                   Telp: (0274) 123456</p>
            </div>
        </div>

        <div class="receipt-title">
            <h1>KUITANSI</h1>
            <p>Nomor: PMB/{{ $payment->id }}/{{ $payment->created_at->format('m/Y') }}</p>
        </div>

        <div class="receipt-body">
            @php
                $invoice = $payment->invoice;
                // Cek apakah pembayaran ini adalah cicilan atau pelunasan
                $isInstallment = $invoice->remaining_amount > 0;
            @endphp
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td style="width: 25%;"><strong>Telah Diterima Dari</strong></td>
                        <td>: {{ $invoice->registration->student->full_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Guna Pembayaran</strong></td>
                        <td>
                            : {{ $invoice->description }}
                            {{-- Tambahkan keterangan cicilan atau lunas --}}
                            @if($isInstallment)
                                <span class="text-muted font-italic">(Pembayaran Cicilan)</span>
                            @else
                                <span class="text-success font-italic">(Pembayaran Lunas)</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah Dibayar</strong></td>
                        <td>: <strong>Rp {{ number_format($payment->amount_paid, 0, ',', '.') }}</strong></td>
                    </tr>
                    {{-- Tampilkan total tagihan jika ini adalah cicilan --}}
                    @if($isInstallment)
                    <tr>
                        <td><strong>Dari Total Tagihan</strong></td>
                        <td>: Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="receipt-footer">
            <p>Kasihan, {{ $payment->created_at->format('d F Y') }}</p>
            <br><br><br>
            <p>( {{ $payment->verifier->name ?? 'Staf Keuangan' }} )</p>
        </div>
    </div>
</body>
</html>