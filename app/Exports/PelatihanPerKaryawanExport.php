<?php

namespace App\Exports;

use App\Models\Periode;
use App\Models\RiwayatPelatihan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PelatihanPerKaryawanExport implements FromCollection, WithHeadings
{
    private $user_id, $year;

    public function __construct($user_id, $year)
    {
        $this->user_id = $user_id;
        $this->year = $year;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $collection = [];
        $pelatihan = RiwayatPelatihan::where('user_id', $this->user_id)->where('periode_id', $this->year)->get();
        foreach ($pelatihan as $p) {
            $wajib = $p->wajib == 1 ? 'Wajib' : 'Tidak Wajib';
            $verified = $p->verified == 1 ? 'Valid' : 'Belum Valid';
            $collection[] = [
                'nama_pelatihan' => $p->nama_pelatihan,
                'nama_penyelenggara' => $p->nama_penyelenggara,
                'tgl_mulai' => $p->tgl_mulai,
                'tgl_selesai' => $p->tgl_selesai,
                'durasi' => $p->durasi . ' jam',
                'wajib' => $wajib,
                'verified' => $verified,
            ];
        }

        return collect($collection);
    }

    public function headings(): array
    {
        return [
            'nama pelatihan',
            'nama penyelenggara',
            'tgl mulai',
            'tgl selesai',
            'durasi',
            'wajib',
            'verified',
        ];
    }
}
