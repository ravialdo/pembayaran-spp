@extends('layouts.dashboard')

@section('breadcrumb')
	<li class="breadcrumb-item active" aria-current="page">Surat</li>
@endsection

@section('content')

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title">Form Surat</div>
					
						<form class="form-horizontal form-material"  enctype="multipart/form-data"  method="post" action="{{ url('dashboard/mail') }}">
						
							@csrf
							
							<div class="col-md-6">
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<label class="input-group-text">
											Tipe Surat *
										</label>
									</div>
									<select name="tipe_surat" class="custom-select">
										<option>Silahkan Pilih</option>
											@foreach($mail_types as $mail_type)                                 
                                                			<option value="{{ $mail_type->id }}">{{ $mail_type->type_name }}</option>
											@endforeach
									</select>
								</div>
							</div>
					
                                    <div class="form-group">
                                        <label class="col-md-12">Kode Surat *</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-line" name="kode_surat">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Surat Dari *</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-line" name="surat_dari">
                                        </div>
                                    </div>
							<div class="form-group">
                                        <label class="col-md-12">Surat Untuk *</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-line" name="surat_untuk">
                                        </div>
                                    </div>
							<div class="form-group">
                                        <label class="col-md-12">Subjek Surat *</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-line" name="subjek_surat">
                                        </div>
                                    </div>
							<div class="form-group">
                                        <label class="col-md-12">Deskripsi *</label>
                                        <div class="col-md-12">
                                            <textarea name="deskripsi" class="form-control form-control-line" rows="5"></textarea>
                                        </div>
                                    </div>
							<div class="form-group">
                                        <label class="col-md-12">File *</label>
                                        <div class="col-md-12">
                                            <input type="file" class="custom-file" name="file">
                                        	<small class="text-muted">Format PDF/DOC/DOCX</small>
								</div>
                                    </div>                                
                                    
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success float-right">Tambah</button>
                                        </div>
                                    </div>
                                </form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title">Data Surat</div>
						<div class="table-responsive mb-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Kode</th>
								    <th scope="col">Tipe</th>
                                            <th scope="col">Ditujukan</th>
                                            <th scope="col">Subjek</th>
								    <th scope="col">Deskripsi</th>
								    <th scope="col">File</th>
								    <th scope="col"></th>                                        
                                        </tr>
                                    </thead>
                                    <tbody>
								@php 
								$i=1;
								@endphp
								@foreach($mails as $mail)
                                        <tr>					    
                                            <th scope="row">{{ $i }}</th>
                                            <td>{{ $mail->mail_code }}</td>
								    <td>{{ $mail->mail_type->type_name }}</td>
                                            <td>{{ $mail->mail_to }}</td>
                                            <td>{{ $mail->mail_subject }}</td>
								    <td>{{ $mail->description }}</td>
								    <td>
										
											<a href="{{ url('dashboard/mail/view', $mail->id) }}" class="btn btn-success btn-sm btn-rounded">
												<i class="mdi mdi-download"></i> Unduh
											</a>
																			
									</td>
                                            <td>										                           
                               	 		  <div class="hide-menu">
                                    			<a href="javascript:void(0)" class="text-dark" id="actiondd" role="button" data-toggle="dropdown">
                                       				<i class="mdi mdi-dots-vertical"></i>
                                    			</a>
                                    				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="actiondd">
                                        			<a class="dropdown-item" href="{{ url('dashboard/mail', $mail->id) }}"><i class="ti-pencil"></i> Edit </a>
											<form method="post" action="{{ url('dashboard/mail', $mail->id) }}" id="delete{{ $mail->id }}">
												@csrf
												@method('delete')
												
												<button type="button" class="dropdown-item" onclick="deleteMail({{ $mail->id }})">
													<i class="ti-trash"></i> Hapus
												</button>	
											
											</form>																																																
                                        			                    							                                                                            
                                				</div>
                            				</div>								
								    </td>					
                                        </tr>
								@php
								$i++;
								@endphp
								@endforeach                                  
                                    </tbody>
                                </table>
                            </div>

					  <!-- Pagination -->
					@if($mails->lastPage() != 1)
						<div class="btn-group float-right">		
						   <a href="{{ $mails->previousPageUrl() }}" class="btn btn-success">
								<i class="mdi mdi-chevron-left"></i>
						    </a>
						    @for($i = 1; $i <= $mails->lastPage(); $i++)
								<a class="btn btn-success {{ $i == $mails->currentPage() ? 'active' : '' }}" href="{{ $mails->url($i) }}">{{ $i }}</a>
						    @endfor
					        <a href="{{ $mails->nextPageUrl() }}" class="btn btn-success">
								<i class="mdi mdi-chevron-right"></i>
							</a>
					   </div>
					@endif
					<!-- End Pagination -->
					
					   @if(count($mails) == 0)
				  			<div class="text-center"> Tidak ada data!</div>
					   @endif
				</div>
			</div>
		</div>
	</div>

@endsection

@section('sweet')

	function deleteMail(id){
			
		swal({
			title:"PERINGATAN!",
			text:"Yakin ingin menghapus data surat?",
			icon:"warning",
			buttons: true
		})
		.then((willDelete) => {
			if(willDelete){
			 	   $('#delete'+id).submit();
			   }
		});
	
	}
	
@endsection