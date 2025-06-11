<?php

namespace App\DataTables;

use App\Models\Tutor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TutorDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editBtn = '<a href="' . route('tutors.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a>';
                return $editBtn;
            })
            ->editColumn('is_active', function ($row) {
                $status = $row->is_active ? 'Aktif' : 'Non-Aktif';
                $badgeClass = $row->is_active ? 'badge-success' : 'badge-secondary';
                return "<span class=\"badge {$badgeClass}\">{$status}</span>";
            })
            ->rawColumns(['action', 'is_active']);
    }

    public function query(Tutor $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('tutor-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons([Button::make('excel'), Button::make('reload')]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false),
            Column::make('name')->title('Nama Tutor'),
            Column::make('phone_number')->title('No. Telepon'),
            Column::make('specialization')->title('Spesialisasi'),
            Column::make('is_active')->title('Status'),
            Column::computed('action')->width(120)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Tutor_' . date('YmdHis');
    }
}
