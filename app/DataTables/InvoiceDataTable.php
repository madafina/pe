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
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()

            ->addColumn('action', function ($row) {
                if (strtolower($row->getCalculatedStatusAttribute()) != 'paid') {
                    return '<a href="javascript:void(0)" 
                               data-id="' . $row->id . '"
                               data-remaining="' . $row->remaining_amount . '"
                               class="btn btn-primary btn-sm record-payment-btn">Catat Bayar</a>';
                }
                return '<span class="text-muted">Lunas</span>';
            })
            ->addColumn('student_name', function ($row) {
                return $row->registration->student->full_name;
            })          
            ->editColumn('amount', function ($row) {
                $sisa = ' (Sisa: Rp ' . number_format($row->remaining_amount, 0, ',', '.') . ')';
                return 'Rp ' . number_format($row->amount, 0, ',', '.') . '<br><small class="text-danger font-italic">' . $sisa . '</small>';
            })
            ->editColumn('due_date', function ($row) {
                return \Carbon\Carbon::parse($row->due_date)->format('d M Y');
            })           
            ->editColumn('status', function ($row) {
                $status = $row->getCalculatedStatusAttribute(); // Gunakan status dinamis
                $badge_class = 'badge-secondary';
                if ($status == 'Paid') $badge_class = 'badge-success';
                if ($status == 'Partially Paid') $badge_class = 'badge-info';
                if ($status == 'Unpaid') $badge_class = 'badge-warning';
                if ($status == 'Overdue') $badge_class = 'badge-danger';
                return "<span class=\"badge {$badge_class}\">{$status}</span>";
            })
            ->rawColumns(['status', 'action','amount']);
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
            // ->minifiedAjax() // Kita hapus ini untuk kontrol penuh
            ->ajax([
                'url' => route('invoices.index'), // Tentukan URL secara eksplisit
                'type' => 'GET',
                'data' => "function(d) {
                        d.status = $('#status_filter').val();
                        // Tambahkan parameter acak untuk mencegah caching
                        d._ = new Date().getTime();
                    }"
            ])
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons([Button::make('excel'), Button::make('reload')]);
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
            Column::computed('amount')->title('Jumlah Tagihan'),
            Column::make('due_date')->title('Jatuh Tempo'),
            Column::make('status')->title('Status'),
            Column::computed('action')->width(100)->addClass('text-center'),
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
