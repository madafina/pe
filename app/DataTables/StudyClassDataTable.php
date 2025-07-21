<?php

namespace App\DataTables;

use App\Models\StudyClass;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StudyClassDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $detailBtn = '<a href="' . route('study-classes.show', $row->id) . '" class="btn btn-info btn-sm">Detail</a>';
                $editBtn = '<a href="' . route('study-classes.edit', $row->id) . '" class="btn btn-warning btn-sm ml-1">Edit</a>';
                return $detailBtn . ' ' . $editBtn;
            })
            // Gunakan eager loading untuk menampilkan nama dari relasi
            // ->addColumn('subject', fn($row) => $row->subject->name)
            ->addColumn('tutor', fn($row) => $row->tutor->name)
            ->editColumn('start_time', fn($row) => \Carbon\Carbon::parse($row->start_time)->format('H:i'))
            ->editColumn('end_time', fn($row) => \Carbon\Carbon::parse($row->end_time)->format('H:i'))
            ->rawColumns(['action']);
    }

    public function query(StudyClass $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['tutor']);

        // Terapkan filter jika ada input dari request
        if ($day = $this->request()->get('day_of_week')) {
            $query->where('day_of_week', $day);
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('studyclass-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->ajax([
                'data' => "function(d) {
                            d.day_of_week = $('#day_filter').val();
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
            Column::make('name')->title('Nama Kelas'),
            // Column::make('subject')->title('Mata Pelajaran'),
            Column::make('tutor')->title('Tutor'),
            Column::make('day_of_week')->title('Hari'),
            Column::make('start_time')->title('Mulai'),
            Column::make('end_time')->title('Selesai'),
            Column::computed('action')->width(60)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'StudyClass_' . date('YmdHis');
    }
}
