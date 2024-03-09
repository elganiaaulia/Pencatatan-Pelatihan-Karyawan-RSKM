<?php

namespace App\DataTables;

use App\Models\RiwayatPelatihan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PelatihanPerKaryawanDataTable extends DataTable
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
            ->editColumn('validasi', function ($item) {
                if($item->verified == 0){
                    return '<a class="btn btn-success my-auto p-2 rounded-1" href="'.route('pelatihan.show',$item).'"><i class="fas fa-check text-white m-0"></i></a>';
                }else{
                    return '<a class="btn btn-danger my-auto p-2 rounded-1" href="'.route('pelatihan.show',$item).'"><i class="fas fa-times text-white m-0"></i></a>';
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
            ->rawColumns(['validasi','wajib','verified', 'bukti_pelatihan']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(RiwayatPelatihan $model): QueryBuilder
    {
        if ($this->userId == 'empty') {
            return $model->newQuery()
                ->select('riwayat_pelatihan.*', 'periode.periode_name', 'users.full_name')
                ->join('periode', 'riwayat_pelatihan.periode_id', '=', 'periode.id')
                ->join('karyawan_per_periode', 'riwayat_pelatihan.user_id', '=', 'karyawan_per_periode.id')
                ->join('users', 'karyawan_per_periode.user_id', '=', 'users.id')
                ->where('riwayat_pelatihan.verified', 0)
                ->where('periode.periode_name', $this->periodeId);
        } else {
            return $model->newQuery()
                ->select('riwayat_pelatihan.*', 'periode.periode_name')
                ->join('periode', 'riwayat_pelatihan.periode_id', '=', 'periode.id')
                ->join('karyawan_per_periode', 'riwayat_pelatihan.user_id', '=', 'karyawan_per_periode.id')
                ->where('riwayat_pelatihan.user_id', $this->userId)
                ->where('periode.periode_name', $this->periodeId);
        }
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pelatihanperkaryawan-table')
                    ->addTableClass('table table-hover overflow-auto')
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
        if($this->userId == 'empty'){
            return [
                Column::make('DT_RowIndex')
                    ->title('No')
                    ->searchable(false)
                    ->orderable(false)
                    ->width(60)
                    ->addClass('text-center align-middle'),
                Column::computed('validasi')
                    ->exportable(false)
                    ->printable(false)
                    ->orderable(false)
                    ->width(60)
                    ->addClass('text-center align-middle'),
                Column::make('verified')
                    ->addClass('text-center align-middle')
                    ->title('Verified'),
                Column::make('wajib')
                    ->addClass('text-center align-middle')
                    ->title('Wajib'),
                Column::make('full_name')
                    ->title('Nama Karyawan')
                    ->addClass('text-center align-middle'),
                Column::make('durasi')
                    ->addClass('text-center align-middle')
                    ->title('Durasi'),
                Column::make('nama_pelatihan')
                    ->addClass('text-center align-middle')
                    ->title('Nama Pelatihan'),
                Column::make('nama_penyelenggara')
                    ->addClass('text-center align-middle')
                    ->title('Penyelenggara'),
                Column::make('bukti_pelatihan')
                    ->addClass('text-center align-middle')
                    ->title('Bukti Pelatihan'),
                Column::make('tgl_mulai')
                    ->addClass('text-center align-middle')
                    ->title('Tanggal Mulai'),
                Column::make('tgl_selesai')
                    ->addClass('text-center align-middle')
                    ->title('Tanggal Selesai'),
            ];
        } else {

            return [
                Column::make('DT_RowIndex')
                    ->title('No')
                    ->searchable(false)
                    ->orderable(false)
                    ->width(60)
                    ->addClass('text-center align-middle'),
                Column::computed('validasi')
                    ->exportable(false)
                    ->printable(false)
                    ->orderable(false)
                    ->width(60)
                    ->addClass('text-center align-middle'),
                Column::make('verified')
                    ->addClass('text-center align-middle')
                    ->title('Verified'),
                Column::make('wajib')
                    ->addClass('text-center align-middle')
                    ->title('Wajib'),
                Column::make('durasi')
                    ->addClass('text-center align-middle')
                    ->title('Durasi'),
                Column::make('nama_pelatihan')
                    ->addClass('text-center align-middle')
                    ->title('Nama Pelatihan'),
                Column::make('nama_penyelenggara')
                    ->addClass('text-center align-middle')
                    ->title('Penyelenggara'),
                Column::make('bukti_pelatihan')
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
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PelatihanPerKaryawan_' . date('YmdHis');
    }
}
