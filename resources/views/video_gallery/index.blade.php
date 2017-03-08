@extends('app')

@section('content')

<div class="container">
	<ol class="breadcrumb">
	  <li><a href="<?php url(); ?>/home">Home</a></li>
	  <li class="active">Video</li>
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
			<form  id="form" class="form" method="post" action='{{ url() }}/video_gallery/store'>
				<input type="hidden" name="_token" id="_token" value="{{{ csrf_token() }}}" />
				<input id='base_url' type="hidden" value="{{ url() }}/video_gallery"></input>

				<div class="form-group">
					<label class="control-label">
					Judul 
						<span class="symbol required"></span>
					</label>
					<div class="controls">
						<input type="text" name="title" class="form-control">
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label">Url Video <span class="symbol required"></span></label>
					<div class="controls">
						<input type="text" name="video_url" class="form-control">

					</div>
				</div>
				<div class="form-group">
					<label class="control-label" >Deskripsi</label>
					<div class="controls">
						<input type="text" class="form-control" name="deskripsi">
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
			<br>
			<div class="row" id="_list_img">
				<?php if(isset($list_video) && $list_video):?>
					<?php foreach($list_video as $row):?>
					<div style="overflow:hidden" class="col-md-3">
						<div class="thumbnail">
							<img alt="" src="<?php echo $row['thumb_img']?>">
							<div class="caption">
							<div class="row">
								<div class="col-md-12 text-center">
									<a onclick="hapus(<?php echo $row['id']?>)" class="btn btn-danger  btn-xs">Hapus</a>
								</div>
							</div>
							</div>
						</div>
					</div>
					<?php endforeach;?>
				<?php endif;?>
			</div>

			
		</div>
	</div>
</div>



<!-- js -->
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('/js/video_gallery.js')}}"></script>
@endsection
