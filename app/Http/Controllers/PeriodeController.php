<?php

namespace App\Http\Controllers;

use App\DataTables\PeriodeDataTable;
use App\Models\KaryawanPerPeriode;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PeriodeDataTable $dataTablePeriode)
    {
        return $dataTablePeriode->render('user_type.auth.periode.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(PeriodeDataTable $Periode)
    {
        $dataTablePeriode = $Periode->html()->ajax(route('periode.index'))->parameters(['processing' => true]);
        return view('user_type.auth.periode.create', compact('dataTablePeriode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'periode_name' => 'required',
        ]);

        $get_all_karyawan = User::where('role_id', 2)->get();

        $periode = Periode::create($request->all());

        // Create KaryawanPerPeriode for all user
        foreach($get_all_karyawan as $user) {
            $karyawan_periode = KaryawanPerPeriode::create([
                'periode_id' => $periode->id,
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('periode.create')->with('success', 'Periode created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $periode = Periode::find($id);
        if(!$periode) {
            return redirect()->route('periode.create')->with('error', 'Periode not found.');
        }
        $periode->status = $periode->status == 0 ? 1 : 0;
        $periode->save();

        return redirect()->route('periode.create')->with('success', 'Status Periode '.$periode->periode_name.' Berhasil Diubah');
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
        $periode = Periode::find($id);
        if(!$periode) {
            return redirect()->route('periode.create')->with('error', 'Periode not found.');
        }

        $this->validate($request, [
            'periode_name' => 'required',
        ]);

        $periode->update($request->all());

        return redirect()->route('periode.create')->with('success', 'Periode '.$periode->periode_name.' updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $periode = Periode::find($id);
        if(!$periode) {
            return redirect()->route('periode.create')->with('error', 'Periode not found.');
        }
        $periode->delete();

        return redirect()->route('periode.create')->with('success', 'Periode '.$periode->periode_name.' deleted successfully.');
    }
}
