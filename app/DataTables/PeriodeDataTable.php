<?php

namespace App\DataTables;

use App\Models\Periode;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PeriodeDataTable extends DataTable
{
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
            $periode = htmlentities($item->periode_name, ENT_QUOTES, 'UTF-8');
            if($item->status == 1){
                return '<a class="btn btn-white my-auto p-2 rounded-1" href="'.route('periode.show',$item->id).'" data-bs-toggle="tooltip" data-bs-original-title="Edit User"><i class="fas fa-toggle-off text-dark m-0"></i></a>
                <a class="btn btn-primary my-auto p-2 rounded-1" href="'.route('periode.edit',$item->id).'" data-bs-toggle="tooltip" data-bs-original-title="Edit Periode"><i class="fas fa-edit text-white m-0"></i></a>
                <button class="btn btn-danger my-auto p-2 rounded-1" onclick="deleteModal('.$item->id.',\''.$periode.'\')"><i class="fas fa-trash-alt text-white m-0"></i></button>';
            } else{
                return '<a class="btn btn-dark my-auto p-2 rounded-1" href="'.route('periode.show',$item->id).'" data-bs-toggle="tooltip" data-bs-original-title="Edit User"><i class="fas fa-toggle-on text-white m-0"></i></a>
                <a class="btn btn-primary my-auto p-2 rounded-1" href="'.route('periode.edit',$item->id).'" data-bs-toggle="tooltip" data-bs-original-title="Edit Periode"><i class="fas fa-edit text-white m-0"></i></a>
                <button class="btn btn-danger my-auto p-2 rounded-1" onclick="deleteModal('.$item->id.',\''.$periode.'\')"><i class="fas fa-trash-alt text-white m-0"></i></button>';
            }
        })
        ->editColumn('status', function ($item) {
            return $item->status == 1 ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Non Aktif</span>';
        })
        ->orderColumn('status', 'status $1')
        ->rawColumns(['action', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Periode $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('periode-table')
                    ->addTableClass('table table-hover table-bordered')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orders([[0, 'asc']])
                    ->lengthMenu([5, 10, 25, 50, 100])
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
                ->width(60)
                ->addClass('text-center'),
            Column::make('periode_name')
                ->addClass('text-center')
                ->title('Tahun Periode'),
            Column::make('status')
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Periode_' . date('YmdHis');
    }
}
