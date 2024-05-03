<?php

namespace App\DataTables\Karyawan;

use App\Models\KaryawanPerPeriode;
use App\Models\RiwayatPelatihan;
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
    protected $userId, $periodeId;

    public function __construct($periodeId, $userId)
    {
        $this->userId = $userId;
        $this->periodeId = $periodeId;
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
                if($item->verified == 0){
                    return '<a href="' . route('pencatatan.edit', $item->id) . '" class="btn btn-primary my-auto p-2 rounded-1"><i class="fas fa-edit text-white m-0"></i></a>';
                } else {
                    return '-';
                }
            })
            ->editColumn('durasi', function ($item) {
                return $item->durasi . ' Jam';
            })
            ->editColumn('wajib', function ($item) {
                return $item->wajib == 1 ? '<span class="text-success">Wajib</span>' : '<span class="text-danger">Tidak Wajib</span>';
            })
            ->editColumn('verified', function ($item) {
                return $item->verified == 1 ? '<span class="text-success">Valid</span>' : '<span class="text-danger">Belum Valid</span>';
            })
            ->editColumn('bukti_pelatihan', function ($item) {
                $bukti_pelatihan = explode(',', $item->bukti_pelatihan);
                $html = '';
                $counter = 1;
                foreach ($bukti_pelatihan as $bukti) {
                    $html .= '<a class="btn bg-gradient-info btn-sm" href="' . asset('bukti/' . $bukti) . '" target="_blank">Bukti ' . $counter . '</a><br>';
                    $counter++; 
                }
                return $html;
            })
            ->orderColumn('verified', 'verified $1')
            ->orderColumn('wajib', 'wajib $1')
            ->rawColumns(['wajib','verified', 'bukti_pelatihan', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(RiwayatPelatihan $model): QueryBuilder
    {
        return $model->newQuery()
            ->select('riwayat_pelatihan.*', 'periode.periode_name', 'karyawan_per_periode.user_id')
            ->join('periode', 'periode.id', '=', 'riwayat_pelatihan.periode_id')
            ->join('karyawan_per_periode', 'karyawan_per_periode.id', '=', 'riwayat_pelatihan.user_id')
            ->where('karyawan_per_periode.user_id', $this->userId)
            ->where('periode_name', $this->periodeId);
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
                    ->orders([[0, 'asc']])
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
                    ->addClass('text-center align-middle'),
            Column::computed('action')
                ->addClass('text-center align-middle')
                ->title('Action'),
            Column::make('wajib')
                ->addClass('text-center align-middle')
                ->title('Wajib'),
            Column::make('verified')
                ->addClass('text-center align-middle')
                ->title('Verified'),
            Column::make('durasi')
                ->addClass('text-center align-middle')
                ->title('Durasi'),
            Column::make('nama_pelatihan')
                ->addClass('text-center align-middle')
                ->title('Nama Pelatihan'),
            Column::make('nama_penyelenggara')
                ->addClass('text-center align-middle')
                ->title('Penyelenggara'),
            Column::computed('bukti_pelatihan')
                ->addClass('text-center align-middle')
                ->title('Bukti Pelatihan'),
            Column::make('tgl_mulai')
                ->addClass('text-center align-middle')
                ->title('Tanggal Mulai'),
            Column::make('tgl_selesai')
                ->addClass('text-center align-middle')
                ->title('Tanggal Selesai'),
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
