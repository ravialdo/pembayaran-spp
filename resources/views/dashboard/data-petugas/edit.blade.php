@extends('layouts.dashboard')

@section('breadcrumb')
     <li class="breadcrumb-item">Dashboard</li>
	<li class="breadcrumb-item">Petugas</li>
     <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')

	<div class="row">
         <div class="col-md-12">
              <div class="card">
                  <div class="card-body">
                       <div class="card-title">{{ __('Tambah Petugas') }}</div>
                     
                        <form method="post" action="{{ url('dashboard/data-petugas', $edit->id) }}" id="edit_data">
                        
                           @csrf
                           @method('put')
                           
                           <div class="input-group mb-3">									
                        <div class="input-group-prepend">										
                           <label class="input-group-text">										 	
                              Level	
                           </label>
                        </div>
                        <select name="level" class="custom-select @error('level') is-invalid @enderror">							
                              <option value="">Silahkan Pilih</option>											
                              <option value="admin" {{ $edit->level == 'admin' ? 'selected' : '' }}>admin</option>
                              <option value="petugas" {{ $edit->level == 'petugas' ? 'selected' : '' }}>petugas</option>
                       </select>
                     </div>
                     <span class="text-danger">@error('level') {{ $message }} @enderror</span>
               
   
                           <div class="form-group">
                              <label>Nama</label>
                              <input type="text" id="nama" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ $edit->name}}">
                              <span class="text-danger">@error('nama') {{ $message }} @enderror</span>
                           </div>
                           
                           <div class="form-group">
                              <label>Email</label>
                              <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $edit->email }}">
                              <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                           </div>
                           
                           <div class="form-group">
                              <label>Password Baru (Opsional)</label>
                              <input type="password" id="new_pass" class="form-control @error('password_baru') is-invalid @enderror" name="password_baru">
                              <span class="text-danger">@error('password_baru') {{ $message }} @enderror</span>
                           </div>
                           
                           <div class="form-group">
                              <label>Konfirmasi Password Baru</label>
                              <input type="password" id="confirm_new_pass" class="form-control">
                              <span class="text-danger">@error('password_baru') {{ $message }} @enderror</span>
                           </div>
                           
                           <input type="hidden" id="old_pass" name="old_pass" value="">
                           
                           <a href="{{ url('dashboard/data-petugas') }}" class="btn btn-primary btn-rounded">
                              <i class="mdi mdi-chevron-left"></i> Kembali
                           </a>
                           
                           <button type="button" class="btn btn-success btn-rounded float-right" onclick="buttonEdit()">
                                 <i class="mdi mdi-check"></i> Simpan
                           </button>
                        
                        </form>
                  </div>
              </div>     
            </div>
         
	</div>

@endsection

@section('sweet')

    function buttonEdit()
    {    
      var new_pass = $('#new_pass').val();
      var confirm_new_pass = $('#confirm_new_pass').val();
   
      if(new_pass == '' ){
            var text = "Masukan Password anda?";
         }else{
            var text = "Masukan Password lama anda?";   
         }
         
         if(new_pass == confirm_new_pass){
               swal.fire({
               icon: 'question',
               title: text,
               input: 'password',
               inputAttributes: {
                  autocapitalize: 'off',
               },
               confirmButtonText: 'Lanjut',
               showLoaderOnConfirm: true,
               showCancelButton: true,
               cancelButtonText: 'Batal',
               cancelButtonColor: '#d33'
            })
            .then((result) => {
               if(result.value){
                      $('#old_pass').val(result.value);
                      $('#edit_data').submit();
                  }else{
                     const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        onOpen: (toast) => {
                           toast.addEventListener('mouseenter', Swal.stopTimer)
                           toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                     });
                    Toast.fire({
                       icon: 'error',
                       title: 'Terjadi Kesalahan!'
                     });
                  }
               });
            }else{
               Toast.fire({
                   icon: 'error',
                   title: 'Konfirmasi Password tidak Cocok!'
                })
            }
         
    }
   
@endsection