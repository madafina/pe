<?php

namespace App\DataTables;

use App\Models\CoursePrice;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class CoursePriceDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editBtn = '<a href="' . route('course-prices.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a>';
                // Kita tidak pakai hapus untuk harga demi keamanan data
                return $editBtn;
            })
            ->addColumn('program', fn($row) => $row->course->name ?? 'N/A')
            ->editColumn('price', fn($row) => 'Rp ' . number_format($row->price, 0, ',', '.'))
            ->editColumn('registration_window', fn($row) => \Carbon\Carbon::parse($row->registration_open_date)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($row->registration_close_date)->format('d M Y'))
            ->editColumn('payment_deadline', fn($row) => \Carbon\Carbon::parse($row->payment_deadline)->format('d M Y'))
            ->rawColumns(['action']);
    }

    public function query(CoursePrice $model): QueryBuilder
    {
        $query = $model->newQuery()->with('course');

        // Terapkan filter jika ada input dari request
        if ($course_id = $this->request()->get('course_id')) {
            $query->where('course_id', $course_id);
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('courseprice-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->ajax([
                'data' => "function(d) {
                        d.course_id = $('#course_filter').val();
                    }"
            ])
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons([Button::make('excel'), Button::make('reload')]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false),
            Column::make('program')->title('Program'),
            Column::make('name')->title('Nama Paket'),
            Column::make('price')->title('Harga'),
            Column::make('registration_window')->title('Jendela Pendaftaran')->orderable(false)->searchable(false),
            Column::make('payment_deadline')->title('Jatuh Tempo Bayar'),
            Column::computed('action')->width(60)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'CoursePrice_' . date('YmdHis');
    }
}
