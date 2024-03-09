<?php

namespace App\DataTables;

use App\Models\KaryawanPerPeriode;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KaryawanPerPeriodeDataTable extends DataTable
{
    protected $periodeName;

    public function __construct($periodeName)
    {
        $this->periodeName = $periodeName;
    }
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn('DT_RowIndex')
            ->editColumn('action', function ($item) {
                return '<a class="btn btn-info my-auto p-2 rounded-1" href="'.route('pelatihan.user', [$this->periodeName,$item]).'"><i class="fas fa-eye text-white m-0"></i></a>';
            })
            ->editColumn('persentase', function ($item) {
                if ($item->persentase < 40) {
                    return '<span class="badge bg-danger">'.$item->persentase.'%</span>';
                } elseif ($item->persentase < 70) {
                    return '<span class="badge bg-warning">'.$item->persentase.'%</span>';
                } elseif ($item->persentase == 100) {
                    return '<span class="badge bg-success">'.$item->persentase.'%</span>';
                } else {
                    return '<span class="badge bg-info">'.$item->persentase.'%</span>';
                }
            })
            ->orderColumn('persentase', 'persentase $1')
            ->rawColumns(['action', 'persentase']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(KaryawanPerPeriode $model): QueryBuilder
    {
        return $model->newQuery()->join('users', 'karyawan_per_periode.user_id', '=', 'users.id')
        ->select('karyawan_per_periode.*', 'users.full_name', 'users.NIK')
        ->join('periode', 'karyawan_per_periode.periode_id', '=', 'periode.id')
        ->where('periode.periode_name', $this->periodeName);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('karyawanperperiode-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
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
            Column::make('DT_RowIndex')
                    ->title('No')
                    ->searchable(false)
                    ->orderable(false)
                    ->width(60)
                    ->addClass('text-center'),
            Column::computed('action')
                    ->title('Aksi')
                    ->exportable(false)
                    ->printable(false)
                    ->orderable(false)
                    ->width(60)
                    ->addClass('text-center'),
            Column::make('full_name')
                    ->title('Nama Karyawan'),
            Column::make('NIK')
                    ->title('NIK'),
            Column::make('persentase')
                    ->title('Persentase')
                    ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'KaryawanPerPeriode_' . date('YmdHis');
    }
}
