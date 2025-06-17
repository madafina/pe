<?php

namespace App\DataTables;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ExpenseDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Expense> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addIndexColumn()
        ->addColumn('action', function($row){ 
            return '<a href="'.route('expenses.edit', $row->id).'" class="btn btn-warning btn-sm">Edit</a>';
        })
       
        ->addColumn('category', fn($row) => $row->expenseCategory->name)
        ->addColumn('recorded_by', fn($row) => $row->user->name)
        ->editColumn('amount', fn($row) => 'Rp ' . number_format($row->amount, 0, ',', '.'))
        ->editColumn('expense_date', fn($row) => \Carbon\Carbon::parse($row->expense_date)->format('d M Y'))
          ->addColumn('proof', function($row) { // <-- Tambah kolom bukti
            if ($row->proof_of_expense) {
                return '<a href="'.asset('storage/' . $row->proof_of_expense).'" target="_blank" class="btn btn-xs btn-info">Lihat Nota</a>';
            }
            return 'Tidak Ada';
        })
        ->rawColumns(['action','proof']); 
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Expense>
     */
    public function query(Expense $model): QueryBuilder
    {
        return $model->newQuery()->with(['expenseCategory', 'user'])->orderBy('expense_date', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('expense-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false),
            Column::make('expense_date')->title('Tgl. Pengeluaran'),
            Column::make('category')->title('Kategori')->name('expenseCategory.name'),
            Column::make('description')->title('Deskripsi'),
            Column::make('amount')->title('Jumlah'),
            Column::make('recorded_by')->title('Dicatat Oleh')->name('user.name'),
            Column::make('proof')->title('Bukti Nota')->orderable(false)->searchable(false),
            Column::computed('action')->width(100)->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Expense_' . date('YmdHis');
    }
}
