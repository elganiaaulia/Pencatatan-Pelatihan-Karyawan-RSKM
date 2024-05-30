<?php

namespace App\Exports;

use App\Models\KaryawanPerPeriode;
use App\Models\Periode;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KaryawanPerYearExport implements FromCollection, WithHeadings
{
    private $periode_id;

    public function __construct($periode_id)
    {
        $this->periode_id = $periode_id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $collection = [];
        $karyawan_per_periode = KaryawanPerPeriode::where('periode_id', $this->periode_id)
        ->join('users', 'users.id', '=', 'karyawan_per_periode.user_id')
        ->select('karyawan_per_periode.persentase as persentase', 'users.full_name as nama', 'users.NIK as NIK', 'users.unit as unit')
        ->get();

        foreach ($karyawan_per_periode as $k) {
            if($k->persentase == 0){
                $persentase = '0%';
            } else {
                $persentase = $k->persentase.'%';
            }

            $collection[] = [
                'nama' => $k->nama,
                'NIK' => $k->NIK,
                'unit' => $k->unit,
                'persentase' => $persentase,
            ];
        }
        return collect($collection);
    }

    public function headings(): array
    {
        return [
            'nama',
            'NIK',
            'unit',
            'persentase',
        ];
    }
}
