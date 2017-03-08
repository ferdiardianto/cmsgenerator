@extends('app')

@section('content')
<div class="container">
	<ol class="breadcrumb">
	  <li><a href="<?php url(); ?>/home">Home</a></li>
	  <li class="active">Profil</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">Profil</div>
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
				<form id="form" method="post" action="{{ url() }}/profile_setting/store">
					<input type="hidden" name="_token" id="_token" value="{{{ csrf_token() }}}" />
					<input id='base_url' type="hidden" value="{{ url() }}/profile_setting">
					<input id='id' name="id" type="hidden" value="{{ $Microsite->id }}">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label" for="inputEmail">Nama Website</label>
							<div class="controls">
								<input type="text" class="form-control"  name="website_name" value="{{ $Microsite->website_name }}">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label" for="inputEmail">Slogan</label>
							<div class="controls">
								<input type="text" class="form-control"  name="slogan" value="{{ $Microsite->slogan }}">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label" for="inputEmail">Deskripsi</label>
							<div class="controls">
								<textarea  name="description" class="form-control">{{ $Microsite->description }}</textarea>
							</div>
						</div>	
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label" for="inputEmail">Author</label>
							<div class="controls">
								<input type="text"  class="form-control"  name="author" value="{{ $Microsite->author }}">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label" for="inputEmail">Email</label>
							<div class="controls">
								<input type="text" class="form-control" name="email" value="{{ $Microsite->email }}">
							</div>
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

<!-- js -->
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('/js/profile_setting.js')}}"></script>
@endsection
