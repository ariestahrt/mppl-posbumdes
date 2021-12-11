<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Roles;
use Validator;


use Illuminate\Http\Request;
use App\Http\Requests\RequestStorePegawai;
use App\Http\Requests\RequestUpdatePegawai;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    // Devs
    public function devs_create()
    {
        return view('devs.create_pegawai');
    }

    public function devs_login()
    {
        return view('pages.login');
    }

    public function devs_auth(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            return json_encode([
                "error" => 0,
                "message" => "Redirecting"
            ]);
        } else {
            return json_encode([
                "error" => 1,
                "message" => "Login Gagal"
            ]);
        }
    }

    public function devs_logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    // Create
    public function create(RequestStorePegawai $request)
    {
        // dd($request->input());
        $pegawai = Pegawai::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'hp' => $request->hp,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);
        
        $roles = $request->roles;
        foreach ($roles as $role) {
            Roles::create([
                'nama' => $role,
                'peg_id' => $pegawai->id
            ]);
        }
        return json_encode([
            "error" => 0,
            "message" => "Pegawai berhasil ditambahkan!"
        ]);
    }

    // Initiate first admin
    public function initiate_admin(){
        $pegawai = Pegawai::create([
            'nama' => 'Admin',
            'alamat' => 'Jl. Desa Tihingan',
            'hp' => '0',
            'username' => 'admin',
            'password' => Hash::make('heart123')
        ]);

        $roles = explode(',', 'admin,gudang,kasir,sales');
        foreach ($roles as $role) {
            Roles::create([
                'nama' => $role,
                'peg_id' => $pegawai->id
            ]);
        }

        return json_encode([
            "error" => 0,
            "message" => "Admin berhasil ditambahkan!"
        ]);

    }
    
    // Read
    public function index()
    {
        // GANTI MENGGUNAKAN WHERE STATUS = TRUE;
        $pegawai = Pegawai::where('status', 1)->get();
        foreach($pegawai as $item){
            //Add roles setiap pegawai
            $item["roles"] = Roles::where("peg_id", $item->id)->get("nama");
        }
        return view("pages.manajemen-pegawai", [
            "pegawai" => $pegawai,
        ]);
    }

    public function get_pegawai($id){
        $pegawai_info = Pegawai::where('id', $id)->first();
        
        $pegawai_roles = [];

        foreach(Roles::where('peg_id', $id)->get("nama") as $role){
            array_push($pegawai_roles, $role->nama);
        }

        return json_encode([
            "pegawai_data" => $pegawai_info,
            "pegawai_roles" => $pegawai_roles
        ]);
    }

    public function get_all_pegawai(){
        // GANTI MENGGUNAKAN WHERE STATUS = TRUE
        $result = [];

        $all_pegawai = Pegawai::where('status', 1)->get();
        foreach ($all_pegawai as $peg) {
            $roles = [];
            foreach(Roles::where('peg_id', $peg->id)->get("nama") as $role){
                array_push($roles, $role->nama);
            }

            array_push($result, [
                "pegawai_data" => $peg,
                "pegawai_roles" => $roles
            ]);
        }

        // $pegawai_subset =  $all_pegawai->map->only(['nama', 'alamat', 'hp', 'roles', 'username', 'created_at']);

        return json_encode(
            $result
        );
    }

    public function api_get_account_info(){
        if(!Auth::check()){
            return redirect('/');
        }else{
            $pegawai_data = Auth::user();
            $roles = [];
            foreach(Roles::where('peg_id', Auth::user()->id)->get("nama") as $role){
                array_push($roles, $role->nama);
            }

            return view('pages.mainpage', ['roles' => $roles, 'nama' => Auth::user()->nama]);
        }
    }

    // Update User Information
    public function update_user_info(RequestUpdatePegawai $request, $id)
    {
        // Update Data Pegawainya
        $pegawai_to_update = Pegawai::where('id', $id);
        $pegawai_to_update->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'hp' => $request->hp,
            'username' => $request->username
        ]);

        // Update Data Rolesnya
        Roles::where('peg_id', $id)->delete();
        $roles = $request->roles;
        foreach ($roles as $role) {
            Roles::create([
                'nama' => $role,
                'peg_id' => $id
            ]);
        }
        // return json
        return json_encode([
            "error" => 0,
            "message" => "Update berhasil dilakukan"
        ]);
    }

    // Update user password
    public function update_user_password(){

    }

    // delete
    public function destroy($id)
    {
        $pegawai = Pegawai::where('id', $id)->first();
        $pegawai->update([
            'status' => 0,
        ]);

        return json_encode([
            "error" => 0,
            "message" => "Berhasil menghapus pegawai"
        ]);
    }

    public function HandleImportPegawaiRequest(Request $request){
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);
        
        return $request;
    }
}
