<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_admin = User::where('role_id', 1)->count();
        $total_karyawan = User::where('role_id', 2)->count();
        $total_periode = Periode::count();
        $info = Informasi::first();
        return view('dashboard', compact('total_admin', 'total_karyawan', 'total_periode', 'info'));
    }

    public function upload(Request $request){
        $imgpath = $request->file('file');  
        $imgname = time().'-'.random_int(999, 10000).'.'.$imgpath->getClientOriginalExtension();
        $imgpath->move(public_path('info_srsrt/'), $imgname);

        // Get the absolute URL of the uploaded image
        $absoluteUrl = url('/info_srsrt/'.$imgname);
        return response()->json(['location' => $absoluteUrl]);
    }

    public function update(Request $request){
        try{
            $request->validate([
                'info_desc' => 'required',
            ]);
    
            $info = Informasi::first();
            if($info){
                $temp_info = str_replace('../../info_srsrt', '/info_srsrt', $request->info_desc);
                $info->info_desc = $temp_info;
                $info->save();
                return redirect()->route('admin.dashboard')->with('success', 'Informasi Berhasil Dibagikan');
            }else{
                $infoNew = Informasi::create([
                    'info_desc' => $request->info_desc,
                ]);
                $temp_info = str_replace('../../info_srsrt', '/info_srsrt', $request->info_desc);
                $infoNew->info_desc = $temp_info;
                $infoNew->save();
                return redirect()->route('admin.dashboard')->with('success', 'Informasi Berhasil Dibagikan');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Error: '.$e->getMessage());
        }
    }
}
