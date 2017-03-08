@extends('app')
@section('content')
<div class="container">
	<ol class="breadcrumb">
	  <li><a href="<?php url(); ?>/home">Home</a></li>
	  <li><a href="<?php url(); ?>/user">User</a></li>
	  <li class="active">Edit Kategori</li>
	</ol>
    <div class="panel panel-default">
        <div class="panel-body">
        	@if(Session::has('success'))
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert">
                        ×
                    </button>
                    <i class="fa fa-check-circle"></i>
                    {{ Session::get('success') }}
                </div>
                @endif


                @if(Session::has('error'))
                <div class="alert alert-danger">
                    <button class="close" data-dismiss="alert">
                        ×
                    </button>
                    <i class="fa fa-times-circle"></i>
                    {{ Session::get('error') }}
                </div>
                @endif     
            <form action="{{ url() }}/user/update" id="form" role="form" method="post">
                <div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Nama Lengkap <span class="symbol required"></span></label>
								<input type="hidden" name="id" class="input-xlarge" placeholder="" value="{{$User->id}}" />
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
								<input type="text" name="name" class="form-control" placeholder="" value="{{$User->name}}" />
						</div>
						<div class="form-group">
							<label class="control-label">Email <span class="symbol required"></span></label>
							<input type="text" name="email" class="form-control" placeholder="" value="{{$User->email}}" />
						</div>				
						<div class="form-group">
							<label class="control-label">Kata sandi <span class="symbol required"></span></label>
							<input type="password" name="password" id="password" value="{{$User->password}}"  class="form-control" placeholder="" disabled/>
						</div>	
						<div class="form-group">
							<label class="control-label">Ulangi kata sandi <span class="symbol required"></span></label>
							<input type="password" id="password2" name="password2"  value="{{$User->password}}" class="form-control" placeholder="" disabled/>
						</div>	
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Grup User <span class="symbol required"></span></label>
								<!-- select group user -->
								<select id='cmbgroup' style="width:100%" name="cmbgroup" class="form-control">
                                <?php
                                    foreach ($Group_user as $row):
                                    	if($User->id_group==$row->id){
                                    		$selectx='selected';
                                    	}else{
                                    		$selectx='';
                                    	}
                                ?>  
                                        <option value="{{ $row->id }}" {{$selectx}}>{{ $row->nama_group }}</option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
						</div>
						<div class="form-group">
							<label class="control-label">Status <span class="symbol required"></span></label>
							<!-- select status -->
							<select class="form-control" id='cmbstatus' name='cmbstatus'>
								<?php
									if($User->status==1){

								?>
										<option value='1' selected>Active</option>
										<option value='0'>NonActive</option>
								<?php
									}else{
								?>
										<option value='1' >Active</option>
										<option value='0' selected>NonActive</option>
								<?php
									}
								?>

							</select>
						</div>
					</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-8">
						</div>
						<div class="col-md-4">
							<button class="btn btn-primary btn-block" type="submit">
								Submit <i class="fa fa-arrow-circle-right"></i>
							</button>
						</div>
					</div>
            </form>
        </div>
    </div>
    
</div>


<!-- js and css -->
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('/js/user_form.js')}}"></script>
@endsection