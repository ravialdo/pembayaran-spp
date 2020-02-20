@extends('layouts.dashboard')

@section('breadcrumb')
   <li class="breadcrumb-item">Dashboard</li>
   <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')

   <div class="row">
      <div class="col-md-12">
      
         <div class="card">
            <div class="card-body">
               <div class="card-title"> Buat Laporan</div>
               
                  <div class="alert alert-warning">Buat laporan pembayaran SPP siswa, semua data siswa akan di rekap dan di buat laporannya.</div>
                       
                  <a href="{{ url('dashboard/laporan/create') }}" class="btn btn-primary btn-rounded">Buat Laporan</a>
                                
            </div>
         </div>
      
      </div>
   </div>

@endsection