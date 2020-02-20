@extends('layouts.dashboard')

@section('breadcrumb')
     <li class="breadcrumb-item">Dashboard</li>
	<li class="breadcrumb-item active">Petugas</li>
@endsection

@section('content')
<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title">Data Petugas</div>
                              <a href="{{ url('dashboard/data-petugas/create') }}" class="btn btn-success btn-rounded float-right mb-3">
                                 <i class="mdi mdi-plus-circle"></i> {{ __('Tambah Petugas') }}
                              </a>
						<div class="table-responsive mb-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">NAMA</th>
								    <th scope="col">EMAIL</th>
                                            <th scope="col">LEVEL</th>
                                            <th scope="col">DIBUAT</th>
								    <th scope="col"></th>                                        
                                        </tr>
                                    </thead>
                                    <tbody>
								@php 
								$i=1;
								@endphp
								@foreach($users as $value)
                                        <tr>					    
                                            <th scope="row">{{ $i }}</th>
                                            <td>{{ $value->name }}</td>
								    <td>{{ $value->email }}</td>
                                            <td>{{ $value->level }}</td>
                                            <td>{{ $value->created_at->format('d M, Y') }}</td>
                                            <td>										                           
                               	 		  <div class="hide-menu">
                                    			<a href="javascript:void(0)" class="text-dark" id="actiondd" role="button" data-toggle="dropdown">
                                       				<i class="mdi mdi-dots-vertical"></i>
                                    			</a>
                                    				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="actiondd">
                                        			<a class="dropdown-item" href="{{ url('dashboard/data-petugas/'. $value->id .'/edit') }}"><i class="ti-pencil"></i> Edit </a>
										     @if(auth()->user()->id != $value->id)
                                                        <form method="post" action="{{ url('dashboard/data-petugas', $value->id) }}" id="delete{{ $value->id }}">
												@csrf
												@method('delete')
												
												<button type="button" class="dropdown-item" onclick="deleteData({{ $value->id }})">
													<i class="ti-trash"></i> Hapus
												</button>	
											
											</form>	
                                                      @endif
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
					@if($users->lastPage() != 1)
						<div class="btn-group float-right">		
						   <a href="{{ $users->previousPageUrl() }}" class="btn btn-success">
								<i class="mdi mdi-chevron-left"></i>
						    </a>
						    @for($i = 1; $i <= $users->lastPage(); $i++)
								<a class="btn btn-success {{ $i == $users->currentPage() ? 'active' : '' }}" href="{{ $users->url($i) }}">{{ $i }}</a>
						    @endfor
					        <a href="{{ $users->nextPageUrl() }}" class="btn btn-success">
								<i class="mdi mdi-chevron-right"></i>
							</a>
					   </div>
					@endif
					<!-- End Pagination -->
					
					   @if(count($users) == 0)
				  			<div class="text-center">Tidak ada data!</div>
					   @endif
				</div>
			</div>
		</div>
	</div>

@endsection

@section('sweet')

   function deleteData(id){
      Swal.fire({
               title: 'PERINGATAN!',
               text: "Yakin ingin menghapus data Petugas?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal',
            }).then((result) => {
               if (result.value) {
                     $('#delete'+id).submit();
                  }
               })
   }
   
@endsection