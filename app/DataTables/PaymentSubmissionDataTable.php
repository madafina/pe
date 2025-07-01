<?php

namespace App\DataTables;

use App\Models\PaymentSubmission;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PaymentSubmissionDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                // Form untuk Approve
                $approveForm = '
                    <form action="' . route('payment_verifications.approve', $row->id) . '" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        <button type="submit" class="btn btn-success btn-sm approve-btn-form">Approve</button>
                    </form>
                ';

                            // Tombol untuk memicu Modal Reject
                            $rejectBtn = '
                    <button class="btn btn-danger btn-sm ml-1 reject-btn-modal" 
                            data-id="' . $row->id . '" 
                            data-action="' . route('payment_verifications.reject', $row->id) . '"
                            data-toggle="modal" 
                            data-target="#rejectModal">
                        Reject
                    </button>
                ';

                return $approveForm . $rejectBtn;
            })

            ->addColumn('student_name', fn($row) => $row->user->name)
            ->addColumn('invoice_number', fn($row) => $row->invoice->invoice_number)
            ->addColumn('proof', function ($row) {
                return '<a href="' . asset('storage/' . $row->proof_path) . '" target="_blank" class="btn btn-xs btn-info">Lihat Bukti</a>';
            })
            ->editColumn('created_at', fn($row) => $row->created_at->format('d M Y, H:i')) // Edit kolom created_at
            ->editColumn('amount', fn($row) => 'Rp ' . number_format($row->amount, 0, ',', '.'))
            ->rawColumns(['action', 'proof']);
    }

    public function query(PaymentSubmission $model): QueryBuilder
    {
        // Ambil hanya yang statusnya pending dan muat relasinya
        return $model->newQuery()
            ->where('status', 'pending')
            ->with(['user', 'invoice']);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('paymentsubmission-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1, 'asc') // Urutkan dari yang paling lama
            ->buttons([Button::make('reload')]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false),
            // PERBAIKAN DI SINI: Gunakan nama kolom asli dari database
            Column::make('created_at')->title('Tgl. Submit'),
            Column::make('student_name')->title('Nama Siswa')->name('user.name'),
            Column::make('invoice_number')->title('No. Invoice')->name('invoice.invoice_number'),
            Column::make('amount')->title('Jumlah Diajukan'),
            Column::make('proof')->title('Bukti Bayar')->orderable(false)->searchable(false),
            Column::computed('action')->width(150)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'PaymentSubmission_' . date('YmdHis');
    }
}
