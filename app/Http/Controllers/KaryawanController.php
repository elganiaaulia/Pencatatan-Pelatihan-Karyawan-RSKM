<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'karyawan']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $info = Informasi::first();
        return view('dashboard', compact('info'));
    }

    public function passwordChange()
    {
        return view('user_type.auth.karyawan.password');
    }

    public function passwordUpdate(Request $request, string $id)
    {
        try{
            $request->validate([
                'password' => 'required|min:6',
                'confirm-password' => 'required|min:6|same:password'
            ]);

            
            $user = User::find($id);
            $user->password = Hash::make($request->password);
            $user->save();
            
            return redirect()->route('karyawan.password')->with('success', 'Password berhasil diubah');
        } catch (\Exception $e) {
            if ($request->password != $request->input('confirm-password')) {
                return redirect()->route('karyawan.password')->with('error', 'Password baru dan konfirmasi password tidak sama');
            }
            return redirect()->route('karyawan.password')->with('error', 'Gagal ubah password');
        }
    }
}
