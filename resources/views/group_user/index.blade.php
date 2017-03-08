@extends('app')

@section('content')

<div class="container">
	<ol class="breadcrumb">
	  <li><a href="<?php url(); ?>/home">Home</a></li>
	  <li class="active">Group User</li>
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
			<input id='base_url' type="hidden" value="{{ url() }}/group_user"></input>
			
			<form action='{{ url() }}/group_user/create'>
				<button type="submit" class="btn btn-primary" >Buat Group User</button>
			</form>
			
			<br>
			<br>

			<!-- datatables -->
			<table class="table table-striped table-bordered" id="data-table">
				<thead>
					<tr>
						<th>#Id</th>
						<th>Nama Group</th>
						<th>Hak Akses</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="4">Loading....</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>



<!-- js -->
<script src="{{ asset('/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('/js/datatables.bootstrap.js')}}"></script>
<script src="{{ asset('/js/group_user.js')}}"></script>

<link href="{{ asset('/css/dataTables.bootstrap.css') }}" rel="stylesheet">

@endsection
