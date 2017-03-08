@extends('app')

@section('content')
<div class="container">
	<ol class="breadcrumb">
	  <li><a href="<?php url(); ?>/home">Home</a></li>
	  <li class="active">Image</li>
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
			<input id='base_url' type="hidden" value="{{ url() }}/image_gallery"></input>
			<input type="hidden" name="_token" id="_token" value="{{{ csrf_token() }}}" />
			
			<form action='{{ url() }}/image_gallery/create'>
				<button type="submit" class="btn btn-primary" >Buat Image</button>
			</form>
			<br>


			<!-- datatables -->
			<table class="table table-striped table-bordered" id="data-table">
				<thead>
					<tr>
						<th>#Id</th>
						<th>Nama Album</th>
						<th>Description</th>
						<th>Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="5">Loading....</td>
					</tr>
				</tbody>
			</table>


		</div>
	</div>
</div>


<!-- js -->
<script src="{{ asset('/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('/js/datatables.bootstrap.js')}}"></script>
<script src="{{ asset('/js/image_gallery.js')}}"></script>
<script src="{{ asset('/js/bootstrap-fileupload.min.js')}}"></script>

<link rel="stylesheet" href="{{ asset('/css/bootstrap-fileupload.min.css')}}">
<link href="{{ asset('/css/dataTables.bootstrap.css') }}" rel="stylesheet">

@endsection
