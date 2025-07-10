<?php

namespace App\DataTables;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TrashedPaymentDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('invoice', fn($row) => $row->invoice->invoice_number)
            ->addColumn('student', fn($row) => $row->invoice->registration->student->full_name)
            ->addColumn('verifier', fn($row) => $row->verifier->name)
            ->addColumn('proof', function ($row) {
                if ($row->proof_of_payment) {
                    return '<a href="' . asset('storage/' . $row->proof_of_payment) . '" target="_blank" class="btn btn-xs btn-info">Lihat Bukti</a>';
                }
                return 'Tidak Ada';
            })
            ->editColumn('payment_date', fn($row) => \Carbon\Carbon::parse($row->payment_date)->format('d M Y'))
            ->editColumn('amount_paid', fn($row) => 'Rp ' . number_format($row->amount_paid, 0, ',', '.'))
           ->addColumn('action', function($row){
                // Form untuk Restore
                $restoreForm = '<form action="'.route('payments.restore', $row->id).'" method="POST" class="d-inline">'.csrf_field().method_field('PUT').'<button type="submit" class="btn btn-success btn-sm">Restore</button></form>';
                return $restoreForm;
            })
            ->editColumn('deleted_at', fn($row) => $row->deleted_at->format('d M Y, H:i'))
            ->rawColumns(['action','proof']);
    }

     public function query(Payment $model): QueryBuilder
    {
        // Menggunakan onlyTrashed() untuk mengambil data dari 'tong sampah'
        return $model->newQuery()->onlyTrashed()->with(['invoice.registration.student', 'verifier']);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('payment-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            // ->orderBy(1, 'desc') // Urutkan dari pembayaran terbaru
            ->buttons([Button::make('excel'), Button::make('reload')]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false),
            Column::make('payment_date')->title('Tgl. Bayar'),
            Column::make('invoice')->title('No. Invoice')->name('invoice.invoice_number'),
            Column::make('student')->title('Nama Siswa')->name('invoice.registration.student.full_name'),
            Column::make('amount_paid')->title('Jumlah Dibayar'),
            Column::make('verifier')->title('Diverifikasi Oleh')->name('verifier.name'),
            Column::make('proof')->title('Bukti Bayar')->orderable(false)->searchable(false),
            Column::make('deleted_at')->title('Dihapus Pada'),
            Column::computed('action')->width(80)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Payments_' . date('YmdHis');
    }
}
