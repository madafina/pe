<?php

namespace App\DataTables;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PaymentDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('invoice', fn($row) => $row->invoice->invoice_number ?? 'N/A')
            ->addColumn('student', fn($row) => $row->invoice->registration->student->full_name ?? 'Siswa Dihapus')
            ->addColumn('verifier', fn($row) => $row->verifier->name ?? 'N/A')
            ->addColumn('proof', function ($row) {
                if ($row->proof_of_payment) {
                    return '<a href="' . asset('storage/' . $row->proof_of_payment) . '" target="_blank" class="btn btn-xs btn-info">Lihat Bukti</a>';
                }
                return 'Tidak Ada';
            })
            ->editColumn('payment_date', fn($row) => \Carbon\Carbon::parse($row->payment_date)->format('d M Y'))
            ->editColumn('amount_paid', fn($row) => 'Rp ' . number_format($row->amount_paid, 0, ',', '.'))
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">Hapus</button>';
            })
            ->rawColumns(['proof', 'action']);
    }

    public function query(Payment $model): QueryBuilder
    {
        return $model->newQuery()
                    ->with(['invoice.registration.student', 'verifier'])
                    ->whereHas('invoice.registration.student')
                    ->orderBy('id', 'desc');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('payment-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->buttons([Button::make('excel'), Button::make('reload')]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false),
            Column::make('payment_date')->title('Tgl. Bayar'),
            Column::make('invoice')->title('No. Invoice'),
            // PERBAIKAN DI SINI:
            // Kita buat kolom ini sebagai 'computed' dan tidak bisa di-sort/search
            // untuk menghindari konflik.
            Column::computed('student')->title('Nama Siswa'),
            Column::make('amount_paid')->title('Jumlah Dibayar'),
            Column::make('verifier')->title('Diverifikasi Oleh'),
            Column::make('proof')->title('Bukti Bayar')->orderable(false)->searchable(false),
            Column::computed('action')->width(60)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Payments_' . date('YmdHis');
    }
}