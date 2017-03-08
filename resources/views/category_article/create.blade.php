@extends('app')
@section('content')
<div class="container">
	<ol class="breadcrumb">
		  <li><a href="<?php url(); ?>/home">Home</a></li>
		  <li><a href="<?php url(); ?>/category_article">Kategori</a></li>
		  <li class="active">Buat Kategori</li>
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
			<div class="row">
				<div class="col-md-12">
					<!-- start: FORM VALIDATION 1 PANEL -->
					<div class="panel panel-default">
						<div class="panel-body">
							<form action="{{ url() }}/category_article/store" role="form" id="form" method="post">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
							<input type="hidden"  class="form-control" id="id" name="id" >
								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label class="control-label">
												Nama Kategori <span class="symbol required"></span>
											</label>
											<input type="text"  class="form-control" id="category_name" name="category_name">
										</div>
									</div>
									<div class="col-md-4">

										<div class="form-group">
											<label class="control-label">
												Status <span class="symbol required"></span>
											</label>
											<select id="status" class="form-control" name="status">
												<option value=1>Published</option>
												<option value=0>Unpubished</option>
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
					<!-- end: FORM VALIDATION 1 PANEL -->
				</div>
			</div>
        </div>
    </div>   
</div>


<!-- js and css -->
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('/js/category_article_form.js')}}"></script>
@endsection