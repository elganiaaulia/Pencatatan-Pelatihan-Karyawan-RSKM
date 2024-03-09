<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('user_type.auth.users.index');
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
        $this->validate($request, [
            'full_name' => 'required',
            'NIK' => 'required|numeric',
            'unit' => 'string',
            'role' => 'required'
        ]);

        $input = $request->all();
        
        $temp = [];
        $temp['password'] = Hash::make($input['NIK']);
        $words = explode(" ", $input['full_name']);
        $temp['email'] = $words[0] . '.' . $input['NIK'];
        
        $user = User::create([
            'full_name' => $input['full_name'],
            'NIK' => $input['NIK'],
            'password' => $temp['password'],
            'email' => $temp['email'],
            'role_id' => $input['role'],
            'unit' => $input['unit'],
        ]);

        return redirect()->route('users.index')->with('success','User created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        $user->password = Hash::make($user->NIK);
        $user->save();
        return redirect()->route('users.index')->with([
            'success' => 'Password reset akun ' .$user->full_name. ' to NIK successfully', 
            'integrity_id' => Hash::make($id)
        ]);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        $roles = Role::all();
        return view('user_type.auth.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{

            $this->validate($request, [
                'full_name' => 'required',
                'email' => 'required',
                'NIK' => 'required|numeric',
                'unit' => 'string',
                'password' => 'nullable|confirmed|required_with:confirm-password',
                'confirm-password' => 'nullable|required_with:password|same:password',
                'role' => 'required'
            ]);
            $user = User::where('id', $id)->first();
            if(!$user){
                return redirect()->route('users.index')->with('error', 'Data user tidak ditemukan!');
            }
            if(empty($request->email)){
                $explode = explode(" ", $request->full_name);
                $email = $explode[0] . '.' . $request->NIK;
            }
    
            $update = [
                'full_name' => $request -> full_name,
                'email' => $email ?? $request -> email,
                'NIK' => $request -> NIK,
                'unit' => $request -> unit,
                'role_id' => $request -> role
            ];
    
            if($request->filled('password')){
                $update['password'] = Hash::make($request->password);
            }
    
            $user->update($update);
            return redirect()->route('users.index')->with('success','User updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('users.edit',$id)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if(!$user){
            return redirect()->route('users.index')->with('error', 'Data user tidak ditemukan!');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success','User deleted successfully');
    }
}
