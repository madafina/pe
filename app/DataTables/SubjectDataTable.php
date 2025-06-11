<?php

namespace App\DataTables;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SubjectDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', fn($row) => '<a href="' . route('subjects.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a>')
            ->addColumn('program', fn($row) => $row->course->name ?? 'N/A') // Tampilkan nama program
            ->rawColumns(['action']);
    }

    public function query(Subject $model): QueryBuilder
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
            ->setTableId('subject-table')
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
            Column::make('name')->title('Nama Mata Pelajaran'),
            Column::make('program')->title('Program')->orderable(false),
            Column::make('description')->title('Deskripsi'),
            Column::computed('action')->width(60)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Subject_' . date('YmdHis');
    }
}
