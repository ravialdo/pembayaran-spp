@extends('layouts.dashboard')

@section('breadcrumb')
	<li class="breadcrumb-item">Dashboard</li>
	<li class="breadcrumb-item">Siswa</li>
     <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')

   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-body">
               <div class="card-title">{{ __('Edit Data Siswa') }}</div>
                  
               <form method="post" action="{{ url('dashboard/data-siswa', $siswa->id) }}">
                  @csrf
                  @method('put')
                  
                   <div class="form-group">
                     <label>NISN</label>
                     <input type="number" class="form-control @error('nisn') is-invalid @enderror" name="nisn" value="{{ $siswa->nisn }}">
                     <span class="text-danger">@error('nisn') {{ $message }} @enderror</span>
                  </div>
                  
                  <div class="form-group">
                     <label>NIS</label>
                     <input type="number" class="form-control @error('nis') is-invalid @enderror" name="nis" value="{{ $siswa->nis }}">
                     <span class="text-danger">@error('nis') {{ $message }} @enderror</span>
                  </div>
                  
                  <div class="form-group">
                     <label>Nama</label>
                     <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ $siswa->nama }}">
                     <span class="text-danger">@error('nama') {{ $message }} @enderror</span>
                  </div>
                  
                     <div class="input-group mb-3">									
                        <div class="input-group-prepend">										
                           <label class="input-group-text">										 	
                              Kelas	
                           </label>
                        </div>
                        <select name="kelas" class="custom-select @error('kelas') is-invalid @enderror" {{ count($kelas) == 0 ? 'disabled' : '' }}>
                           @if(count($kelas) == 0)											
                              <option>Pilihan tidak ada</option>
                           @else											
                              <option value="">Silahkan Pilih</option>											
                                 @foreach($kelas as $value) 			
                                    <option value="{{ $value->id }}" {{ $siswa->id_kelas == $value->id ? 'selected' : '' }}>{{ $value->nama_kelas }}</option>
                                 @endforeach
                           @endif	
                       </select>
                     </div>
                     <span class="text-danger">@error('kelas') {{ $message }} @enderror</span>
                                    
                  <div class="form-group">
                     <label>Nomor Telepon</label>
                     <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" name="nomor_telepon" value="{{ $siswa->nomor_telp }}">
                     <span class="text-danger">@error('nomor_telepon') {{ $message }} @enderror</span>
                  </div>
                  
                  <div class="form-group">
                     <label>Alamat</label>
                     <textarea class="form-control @error('alamat') is-invalid @enderror" rows="5" name="alamat">{{ $siswa->alamat }}</textarea>
                     <span class="text-danger">@error('alamat') {{ $message }} @enderror</span>
                  </div>
                  
                  <div class="input-group mb-3">									
                        <div class="input-group-prepend">										
                           <label class="input-group-text">										 	
                              SPP	
                           </label>
                        </div>
                        <select name="spp" class="custom-select @error('spp') is-invalid @enderror" {{ count($spp) == 0 ? 'disabled' : '' }}>
                           @if(count($spp) == 0)											
                              <option>Pilihan tidak ada</option>
                           @else											
                              <option value="">Silahkan Pilih</option>											
                                 @foreach($spp as $value) 			
                                    <option value="{{ $value->id }}" {{ $siswa->id_spp == $value->id ? 'selected' : '' }}>{{ 'Tahun '.$value->tahun.' - '.'Rp.'.$value->nominal }}</option>
                                 @endforeach
                           @endif	
                       </select>
                     </div>
                     <span class="text-danger">@error('spp') {{ $message }} @enderror</span>
               
                      <div class="border-top">
            
               <button type="submit" class="btn btn-success btn-rounded float-right mt-3">
                     <i class="mdi mdi-check"></i> {{ __('Simpan') }}
                 </button>
                 
                 <a href="{{ url('dashboard/data-siswa') }}" class="btn btn-primary btn-rounded mt-3">
                     <i class="mdi mdi-chevron-left"></i> {{ __('Kembali') }}
                 </a>
               </form>
               
            </div>
            </div>
           
         </div>
      </div>
   </div>

@endsection