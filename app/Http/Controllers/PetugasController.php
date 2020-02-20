<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Alert;

class PetugasController extends Controller
{
   
   public function __construct(){
         $this->middleware([
            'auth',
            'privilege:admin'
         ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'users' => User::orderBy('id', 'DESC')->paginate(10),
            'user' => User::find(auth()->user()->id)
         ];
         
         return view('dashboard.data-petugas.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
               'user' => User::find(auth()->user()->id)
         ];
         
          return view('dashboard.data-petugas.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $messages = [
              'required' => ':attribute tidak boleh kosong!',
               'min' => ':attribute minimal :min karakter!',
               'unique' => ':attribute sudah digunakan!',
               'max' => ':attribute maksimal :max karakter',
         ];
         
         $req->validate([
            'level' => 'required',
            'nama' => 'required|max:15',
            'email' => 'required|unique:users',
            'password' => 'required|min:8'
         ], $messages);
         
                if(User::create([
                     'name' => $req->nama,
                     'email' => $req->email,
                     'level' => $req->level,
                     'password' => Hash::make($req->password)
                 ])) :
                    Alert::success('Berhasil!', 'Data User Berhasil di Tambahkan');
               else :
                  Alert::error('Terjadi Kesalahan!', 'Data User Gagal di Tambahkan');
            endif;
        
   
            return redirect('dashboard/data-petugas');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $data = [
             'user' => User::find(auth()->user()->id),
             'edit' => User::find($id)
         ];
         
         return view('dashboard.data-petugas.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        if($update = User::find($id)) :
            
            if(Hash::check($req->old_pass, $update->password)) :
                 
               $update->update([
                   'name' => $req->nama,
                   'email' => $req->email,
                   'level' => $req->level
              ]);
            
              Alert::success('Berhasil!', 'Data Berhasil di Edit');
              return redirect('dashboard/data-petugas');
            
           else :
               Alert::error('Terjadi Kesalahan!', 'Password Anda tidak Cocok');
            endif;
         endif;
        
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($destroy = User::find($id)) :
             $destroy->delete();
               Alert::success('Berhasil!', 'Data Berhasil di Hapus');
         else :
               Alert::error('Terjadi Kesalahan!', 'Data Gagal di Hapus');
         endif;
         
         return back();
    }
}
