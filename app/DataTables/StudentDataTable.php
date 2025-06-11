<?php

namespace App\DataTables;

use App\Models\Student;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StudentDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn() // Menambahkan kolom nomor urut (DT_RowIndex)
            ->addColumn('action', function ($row) {
                // Ubah tombol menjadi link ke halaman detail
                $btn = '<a href="' . route('students.show', $row->id) . '" class="btn btn-sm btn-info">Detail</a>';
                return $btn;
            })
            ->addColumn('program', function ($row) {
                // Kolom kustom untuk menampilkan nama program
                if ($row->registration && $row->registration->coursePrice && $row->registration->coursePrice->course) {
                    return $row->registration->coursePrice->course->name;
                }
                return 'N/A';
            })
            ->editColumn('registration_date', function ($row) {
                // Memformat tanggal
                return \Carbon\Carbon::parse($row->registration_date)->format('d M Y');
            })
            ->editColumn('status', function ($row) {
                $status = $row->status;
                $badgeClass = 'badge-secondary';
                if ($status == 'Aktif') $badgeClass = 'badge-success';
                if ($status == 'Non-Aktif') $badgeClass = 'badge-warning';
                if ($status == 'Lulus') $badgeClass = 'badge-info';
                if ($status == 'Berhenti') $badgeClass = 'badge-danger';
                return "<span class=\"badge {$badgeClass}\">{$status}</span>";
            })
            // ->editColumn('registration.initial_payment_status', function ($row) {
            //     // Memformat status dengan badge
            //     if ($row->registration) {
            //         $status = $row->registration->initial_payment_status;
            //         $badgeClass = $status == 'Paid' ? 'badge-success' : 'badge-warning';
            //         return "<span class=\"badge {$badgeClass}\">{$status}</span>";
            //     }
            //     return 'N/A';
            // })
            ->rawColumns(['action', 'registration.initial_payment_status', 'status']); // Memberitahu datatables kolom mana yang berisi HTML
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Student $model): QueryBuilder
    {
        $query = $model->newQuery()->with('registration.coursePrice.course');

        // TERAPKAN FILTER JIKA ADA INPUT DARI REQUEST
        if ($this->request()->get('course_id')) {
            $course_id = $this->request()->get('course_id');
            $query->whereHas('registration.coursePrice', function ($q) use ($course_id) {
                $q->where('course_id', $course_id);
            });
        }

        // Filter berdasarkan Status Siswa (yang baru)
        if ($status = $this->request()->get('status')) {
            $query->where('status', $status);
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('student-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ])
            ->ajax([
                'data' => "function(d) {
                        d.course_id = $('#course_filter').val();
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
            Column::make('full_name')->title('Nama Lengkap'),
            Column::make('program')->title('Program')->orderable(false)->searchable(false),
            Column::make('registration_date')->title('Tgl. Daftar'),
            Column::make('status')->title('Status Siswa'),
            // Column::make('registration.initial_payment_status')->title('Status Tagihan Awal')->orderable(false)->searchable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Student_' . date('YmdHis');
    }
}
