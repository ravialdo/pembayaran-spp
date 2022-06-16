<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembayaran;
use App\User;
use App\Siswa;
use Alert;
use Symfony\Component\Console\Input\Input;

class PembayaranController extends Controller
{
   
   public function __construct(){
         $this->middleware([
            'auth',
            'privilege:admin&petugas'
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
            'pembayaran' => Pembayaran::orderBy('id', 'DESC')->paginate(10),
            'user' => User::find(auth()->user()->id)
        ];
      
        return view('dashboard.entri-pembayaran.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
      $date_month = $req->spp_bulan;

         $message = [
            'required' => ':attribute harus di isi',
            'numeric' => ':attribute harus berupa angka',
            'min' => ':attribute minimal harus :min angka',
            'max' => ':attribute maksimal harus :max angka',
         ];
         
      $req->validate([
            'nisn' => 'required',
            'spp_bulan' => 'required',
            'jumlah_bayar' => 'required|numeric'
         ], $message);
         
         if(Siswa::where('nisn',$req->nisn)->exists() == false):
            Alert::error('Terjadi Kesalahan!', 'Siswa dengan NISN ini Tidak di Temukan');
            return redirect()->back()->withInput();
            exit;
         endif;

         if($date_month > date("m")) {
            $month = $this->string_month($date_month);
            Alert::warning("Terjadi kesalahan!", "Maaf, pembayaran bulan " . $month . " belum dibuka");
            return redirect()->back()->withInput();
            exit;
         }else{
            $year = date("Y");
            $date_payment = $year . "-" . $req->spp_bulan . "-01";
            $siswa = Siswa::where("nisn", $req->nisn)->first();
            $pembayaran = Pembayaran::where("id_siswa", $siswa->id)->where("spp_bulan", $date_payment)->first();
            if($pembayaran){
               $month = $this->string_month($date_month);
               Alert::warning("Terjadi kesalahan!", "Maaf, pembayaran bulan " . $month . " telah dibayar");
               return redirect()->back()->withInput();
               exit;
            }
            
         
         $siswa = Siswa::where('nisn',$req->nisn)->get();
         
         foreach($siswa as $val){
            $id_siswa = $val->id;
         }
         
         Pembayaran::create([
            'id_petugas' => auth()->user()->id,
            'id_siswa' => $id_siswa,
            'spp_bulan' => date("Y-$req->spp_bulan-01"),
            'jumlah_bayar' => $req->jumlah_bayar,
         ]);
         
         Alert::success('Berhasil!', 'Pembayaran Berhasil di Tambahkan!');
         
         return back();
      }
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
            'edit' => Pembayaran::find($id),
            'user' => User::find(auth()->user()->id)
         ];
         
         return view('dashboard.entri-pembayaran.edit', $data);
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
         $message = [
            'required' => ':attribute harus di isi',
            'numeric' => ':attribute harus berupa angka',
            'min' => ':attribute minimal harus :min angka',
            'max' => ':attribute maksimal harus :max angka',
         ];
         
        $req->validate([
            'nisn' => 'required',
            'spp_bulan' => 'required',
            'jumlah_bayar' => 'required|numeric'
         ], $message);
         
         $pembayaran = Pembayaran::find($id);
         
         $pembayaran->update([
             'spp_bulan' => $req->spp_bulan,
            'jumlah_bayar' => $req->jumlah_bayar
         ]);
         
         if(Siswa::where('nisn',$req->nisn)->exists() == false):
            Alert::error('Terjadi Kesalahan!', 'Siswa dengan NISN ini Tidak di Temukan');
           return back();
            exit;
         endif;

         if($req->nisn != $pembayaran->siswa->nisn) :
            $siswa = Siswa::where('nisn',$req->nisn)->get();
         
            foreach($siswa as $val){
               $id_siswa = $val->id;
            }
            
            $pembayaran->update([
               'id_siswa' => $id_siswa,
            ]);
         endif;
         
         Alert::success('Berhasil!', 'Pembayaran berhasil di Edit');
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
        if(Pembayaran::find($id)->delete()) :
            Alert::success('Berhasil!', 'Pembayaran Berhasil di Hapus!');
         else :
            Alert::success('Terjadi Kesalahan!', 'Pembayaran Gagal di Tambahkan!');
         endif;
         
         return back();
    }

   public function string_month($date_month){
      switch ($date_month) {
         case '01':
            $date_month = "Januari";
         break;
         case '02':
            $date_month = "Februari";
         break;
         case '03':
            $date_month = "Maret";
         break;
         case '04':
            $date_month = "April";
         break;
         case '05':
            $date_month = "Mei";
         break;
         case '06':
            $date_month = "Juni";
         break;
         case '07':
            $date_month = "Juli";
         break;
         case '08':
            $date_month = "Agustus";
         break;
         case '09':
            $date_month = "September";
         break;
         case '10':
            $date_month = "Oktober";
         break;
         case '11':
            $date_month = "November";
         break;
         case '12':
            $date_month = "Desember";
         break;
         
         default:
            "Kode bulan salah!";
            break;
      }

      return $date_month;
   }
}
