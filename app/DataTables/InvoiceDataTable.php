<?php

namespace App\DataTables;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class InvoiceDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                // Hanya tampilkan tombol jika statusnya 'Unpaid'
                if ($row->status == 'Unpaid') {
                    $btn = '<a href="javascript:void(0)" 
                   data-id="' . $row->id . '" 
                   class="btn btn-primary btn-sm verify-btn">Verifikasi</a>';
                    return $btn;
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->addColumn('student_name', function ($row) {
                return $row->registration->student->full_name;
            })
            ->editColumn('amount', function ($row) {
                return 'Rp ' . number_format($row->amount, 0, ',', '.');
            })
            ->editColumn('due_date', function ($row) {
                return \Carbon\Carbon::parse($row->due_date)->format('d M Y');
            })
            ->editColumn('status', function ($row) {
                $status = $row->status;
                if ($status == 'Paid') {
                    $badgeClass = 'badge-success';
                } elseif ($status == 'Overdue') {
                    $badgeClass = 'badge-danger';
                } else {
                    $badgeClass = 'badge-warning';
                }
                return "<span class=\"badge {$badgeClass}\">{$status}</span>";
            })
            ->rawColumns(['status', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Invoice $model): QueryBuilder
    {
        $query = $model->newQuery()->with('registration.student');

        // TERAPKAN FILTER JIKA ADA INPUT DARI REQUEST
        if ($this->request()->get('status')) {
            $query->where('status', $this->request()->get('status'));
        }

        return $query;
    }


    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('invoice-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons([Button::make('excel'), Button::make('reload')])
            ->ajax([
                'data' => "function(d) {
                        d.status = $('#status_filter').val();
                    }"
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false),
            Column::make('invoice_number')->title('No. Invoice'),
            Column::make('student_name')->title('Nama Siswa'),
            Column::make('amount')->title('Jumlah'),
            Column::make('due_date')->title('Jatuh Tempo'),
            Column::make('status')->title('Status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Invoice_' . date('YmdHis');
    }
}
