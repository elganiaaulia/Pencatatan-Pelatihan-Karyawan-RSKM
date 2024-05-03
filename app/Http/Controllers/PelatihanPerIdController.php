<?php

namespace App\Http\Controllers;

use App\DataTables\Karyawan\KaryawanPerPeriodeDataTable;
use App\Models\KaryawanPerPeriode;
use App\Models\PelatihanWajibPerPeriode;
use App\Models\Periode;
use App\Models\RiwayatPelatihan;
use Illuminate\Http\Request;

class PelatihanPerIdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function createByYear(string $year)
    {
        $periode_id = Periode::where('periode_name', $year)->first()->id;
        $pelatihan_wajib = PelatihanWajibPerPeriode::where('periode_id', $periode_id)->get();
        return view('user_type.auth.karyawan.pelatihan-create', compact('year', 'pelatihan_wajib'));
    }

    public function storeByYear(Request $request, string $year)
    {
        $bukti_pelatihan = null;
        $durasi = 0;
        try{
            $this->validate($request, [
                'wajib' => 'required|in:1,0',
                'nama_pelatihan' => 'required',
                'tgl_mulai' => 'required',
                'tgl_selesai' => 'required',
            ]);

            $periode_id = Periode::where('periode_name', $year)->first()->id;
            $karyawan_periode = KaryawanPerPeriode::where('periode_id', $periode_id)->where('user_id', auth()->user()->id)->first();
            if(!$karyawan_periode){
                $karyawan_periode = KaryawanPerPeriode::create(
                    [
                    'periode_id' => $periode_id,
                    'user_id' => auth()->user()->id,
                    'persentase' => 0,
                    ]
                );
            }
            
            if(count($request->file('bukti_pelatihan', [])) > 0){
                foreach($request->file('bukti_pelatihan', []) as $file){
                    $file_name = auth()->user()->NIK.'_'.uniqid().'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('bukti'), $file_name);
                    $bukti_pelatihan[] = $file_name;
                }
                $bukti_pelatihan = implode(',', $bukti_pelatihan);
            }

            $tgl_mulai = strtotime($request->tgl_mulai);
            $tgl_selesai = strtotime($request->tgl_selesai);
            $durasi = ($tgl_selesai - $tgl_mulai) / 3600;
            if($durasi < 0){
                return redirect()->back()->with('error', 'Durasi pelatihan tidak boleh kurang dari 0 jam');
            }
            
            $pelatihan = RiwayatPelatihan::create(
                [
                'user_id' => $karyawan_periode->id,
                'periode_id' => $periode_id,
                'wajib' => $request->wajib,
                'nama_pelatihan' => $request->nama_pelatihan,
                'nama_penyelenggara' => $request->nama_penyelenggara,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'bukti_pelatihan' => $bukti_pelatihan,
                'durasi' => $durasi,
                'verified' => 0
                ]
            );
            return redirect()->route('pencatatan.show',$year)->with('success', 'Pelatihan berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $year = $id;
        $datatable = new KaryawanPerPeriodeDataTable($year, auth()->user()->id);
        try{
            $periode_id = Periode::where('periode_name', $year)->first()->id;
            $persentase = KaryawanPerPeriode::where('user_id', auth()->user()->id)->where('periode_id', $periode_id)->first();
            $sum_durasi = RiwayatPelatihan::where('user_id', $persentase->id)->where('periode_id', $persentase->periode_id)->where('verified', 1)->sum('durasi');
            $persentase = $persentase->persentase.'%';
        } catch (\Exception $e) {
            $persentase = '0%';
            $sum_durasi = 0;
        }
        return $datatable->render('user_type.auth.karyawan.pelatihan', compact('year', 'persentase', 'sum_durasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pelatihan = RiwayatPelatihan::find($id);
        $bukti_pelatihan = null;
        if(!$pelatihan){
            return redirect()->back()->with('error', 'Pelatihan not found.');
        }
        
        if($pelatihan->verified == 1){
            return redirect()->back()->with('error', 'Pelatihan sudah diverifikasi.');
        }

        $pelatihan_wajib = PelatihanWajibPerPeriode::where('periode_id', $pelatihan->peiode_id)->get();
        $year = Periode::find($pelatihan->periode_id)->periode_name;
        if($pelatihan->bukti_pelatihan){
            $bukti_pelatihan = explode(',', $pelatihan->bukti_pelatihan);
        }
        return view('user_type.auth.karyawan.pelatihan-edit', compact('year', 'pelatihan', 'pelatihan_wajib', 'bukti_pelatihan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $year, string $id)
    {
        $pelatihan = RiwayatPelatihan::where('id', $id)->first();
        $periode_id = Periode::where('periode_name', $year)->first()->id;
        if(!$pelatihan || $pelatihan->verified == 1 || $pelatihan->periode_id != $periode_id){
            return redirect()->back()->with('error', 'Pelatihan not found.');
        }

        $bukti_pelatihan = null;
        $durasi = 0;
        try{
            if(count($request->file('bukti_pelatihan', [])) > 0){
                foreach($request->file('bukti_pelatihan', []) as $file){
                    $file_name = auth()->user()->NIK.'_'.uniqid().'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('bukti'), $file_name);
                    $bukti_pelatihan[] = $file_name;
                }
                $bukti_pelatihan = implode(',', $bukti_pelatihan);
                $bukti_pelatihan = $request->old_bukti_pelatihan.','.$bukti_pelatihan;
            } else {
                $bukti_pelatihan = $request->old_bukti_pelatihan;
            }

            $tgl_mulai = strtotime($request->tgl_mulai);
            $tgl_selesai = strtotime($request->tgl_selesai);
            $durasi = ($tgl_selesai - $tgl_mulai) / 3600;
            if($durasi < 0){
                return redirect()->back()->with('error', 'Durasi pelatihan tidak boleh kurang dari 0 jam');
            }
            
            $update = [
                'wajib' => $request->wajib,
                'nama_pelatihan' => $request->nama_pelatihan,
                'nama_penyelenggara' => $request->nama_penyelenggara,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'bukti_pelatihan' => $bukti_pelatihan,
                'durasi' => $durasi,
                'verified' => 0
            ];
            $pelatihan->update($update);
            return redirect()->route('pencatatan.show',$year)->with('success', 'Pelatihan berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
