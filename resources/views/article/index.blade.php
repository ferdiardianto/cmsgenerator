@extends('app')

@section('content')
<div class="container">
	<ol class="breadcrumb">
	  <li><a href="<?php url(); ?>/home">Home</a></li>
	  <li class="active">Artikel</li>
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
			<input type="hidden" name="_token" id="_token" value="{{{ csrf_token() }}}" />
			<input id='base_url' type="hidden" value="{{ url() }}/article"></input>
			
			<form action='{{ url() }}/article/create'>
				<button type="submit" class="btn btn-primary" >Buat Artikel</button>
			</form>
			
			<br>
			<br>

			<!-- datatables -->
			<table class="table table-striped table-bordered" id="data-table">
				<thead>
					<tr>
						<th>#Id</th>
						<th>Nama Category</th>
						<th>Tanggal</th>
						<th>Judul</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="6">Loading....</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- js -->
<script src="{{ asset('/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('/js/datatables.bootstrap.js')}}"></script>
<script src="{{ asset('/js/article.js')}}"></script>

<link href="{{ asset('/css/dataTables.bootstrap.css') }}" rel="stylesheet">

@endsection
