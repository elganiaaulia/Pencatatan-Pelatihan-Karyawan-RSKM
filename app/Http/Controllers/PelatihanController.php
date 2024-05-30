<?php

namespace App\Http\Controllers;

use App\DataTables\KaryawanPerPeriodeDataTable;
use App\DataTables\PelatihanPerKaryawanDataTable;
use App\Exports\KaryawanPerYearExport;
use App\Models\KaryawanPerPeriode;
use App\Models\PelatihanWajibPerPeriode;
use App\Models\Periode;
use App\Models\RiwayatPelatihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;


class PelatihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 
    }

    public function pelatihanById(string $year, string $id)
    {
        $karyawan_periode = KaryawanPerPeriode::find($id);
        $find_user = User::find($karyawan_periode->user_id);
        $full_name = $find_user->full_name;
        $dataTable = new PelatihanPerKaryawanDataTable($year, $id);
        return $dataTable->render('user_type.auth.pelatihan.show', compact('id', 'year', 'karyawan_periode', 'full_name'));
    }
    
    public function pelatihanValidation(string $year)
    {
        $dataTable = new PelatihanPerKaryawanDataTable($year, 'empty');
        $id = '';
        $karyawan_periode = null;
        $full_name = null;
        return $dataTable->render('user_type.auth.pelatihan.show', compact('year', 'id', 'karyawan_periode', 'full_name'));
    }

    public function pelatihanByPeriode(string $year)
    {
        $dataTable = new KaryawanPerPeriodeDataTable($year);
        $pelatihan_wajib = PelatihanWajibPerPeriode::where('periode_id', Periode::where('periode_name', $year)->first()->id)->get();
        return $dataTable->render('user_type.auth.pelatihan.index', compact('year', 'pelatihan_wajib'));
    }

    public function pelatihanByValidate(string $validate)
    {
        return view('user_type.auth.pelatihan.show');
    }

    public function pelatihanByPeriodeGrafik(string $year)
    {
        $periode = Periode::where('periode_name', $year)->first();
        $data = KaryawanPerPeriode::where('periode_id', $periode->id)
                ->selectRaw('COUNT(*) as count, FLOOR(persentase / 20) * 20 as `range`')
                ->groupBy('range')
                ->pluck('count', 'range');
        $statistik = KaryawanPerPeriode::all()->where('periode_id', $periode->id);
        $terpenuhi = 0;
        $tidak_terpenuhi = 0;
        foreach ($statistik as $karyawan) {
            if ($karyawan->persentase == 100) {
                $terpenuhi++;
            } else {
                $tidak_terpenuhi++;
            }
        }

        $labels = [];
        $counts = [];
        foreach ($data as $range => $count) {
            if($range == 100) {
                $labels[] = '100';
                $counts[] = $count;
            } else if($range == 80) {
                $labels[] = '80-99';
                $counts[] = $count;
            } else {
                $labels[] = $range . '-' . ($range + 19);
                $counts[] = $count;
            }
        }
        // using foreach make bubble sorting data of labels but count in same index remain same with labels that same before sorting, by ascending the labels
        for ($i = 0; $i < count($labels); $i++) {
            for ($j = $i + 1; $j < count($labels); $j++) {
                if ($labels[$i] == '100') {
                    $temp = $labels[$i];
                    $labels[$i] = $labels[$j];
                    $labels[$j] = $temp;
                } else if ($labels[$i] == '80-99' && $labels[$j] != '100') {
                    $temp = $labels[$i];
                    $labels[$i] = $labels[$j];
                    $labels[$j] = $temp;
                }
            }
        }

        //then add % to each label
        for ($i = 0; $i < count($labels); $i++) {
            $labels[$i] .= '%';
        }
        return view('user_type.auth.pelatihan.grafik', compact('year', 'labels', 'counts', 'terpenuhi', 'tidak_terpenuhi'));
    }

    public function createPelatihanWajib(Request $request ,string $year)
    {
        //
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $periode = Periode::where('periode_name', $request->periode_id)->first();
            if(!$request->periode_id) {
                return redirect()->back()->with('error', 'Periode not found.');
            }
            $this->validate($request, [
                'periode_id' => 'required',
                'nama_pelatihan' => 'required',
            ]);
            PelatihanWajibPerPeriode::create([
                'periode_id' => $periode->id,
                'nama_pelatihan' => $request->nama_pelatihan,
            ]);
            return redirect()->back()->with('success', 'Pelatihan Wajib Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $riwayat_pelatihan = RiwayatPelatihan::find($id);
        if(!$riwayat_pelatihan) {
            return redirect()->back()->with('error', 'Pelatihan not found.');
        }
        $riwayat_pelatihan->verified = $riwayat_pelatihan->verified == 0 ? 1 : 0;
        $riwayat_pelatihan->save();
        
        $persentase = RiwayatPelatihan::where('user_id', $riwayat_pelatihan->user_id)
                        ->where('periode_id', $riwayat_pelatihan->periode_id)
                        ->where('verified', 1);
        if(!$persentase){
            return redirect()->back()->with('error', 'Pelatihan not found.');
        }
        $persentase = ($persentase->sum('durasi') / 200) * 100;
        if($persentase > 100) {
            $persentase = 100;
        }
        $karyawan_per_periode = KaryawanPerPeriode::find($riwayat_pelatihan->user_id);
        $karyawan_per_periode->persentase = $persentase;
        $karyawan_per_periode->save();
        
        return redirect()->back()->with('success', 'Pelatihan '.$riwayat_pelatihan->nama_pelatihan.' status updated successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelatihan_wajib = PelatihanWajibPerPeriode::find($id);
        if(!$pelatihan_wajib) {
            return redirect()->back()->with('error', 'Pelatihan not found.');
        }
        $pelatihan_wajib->delete();
        return redirect()->back()->with('success', 'Pelatihan wajib deleted successfully.');
    }

    public function ExportByYear(string $year)
    {
        $periode_id = Periode::where('periode_name', $year)->first()->id;
        return Excel::download(new KaryawanPerYearExport($periode_id), 'Pelatihan-Karyawan-'.$year.'.xlsx');
    }
}
