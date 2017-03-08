@extends('app')

@section('content')
<div class="container">
	<ol class="breadcrumb">
	  <li><a href="<?php url(); ?>/home">Home</a></li>
	  <li class="active">Cover dan Headline</li>
	</ol>
	<div class="panel panel-default">
		<div class="panel-heading">Cover</div>
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
			<input id='base_url' type="hidden" value="{{ url() }}/frontpage_setting">

			<form method="post" action="{{ url() }}/frontpage_setting/do_upload" class="form-horizontal" enctype="multipart/form-data" id="form_cover">
				<input type="hidden" name="_token" id="_token" value="{{{ csrf_token() }}}" />
			
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<div class="col-sm-12">
							<label class="control-label">
								Masukan gambar <span class="text-muted">(Ukuran : 980 X 320)</span>
							</label>
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="input-group">
									<div class="form-control uneditable-input">
										<i class="fa fa-file fileupload-exists"></i>
										<span class="fileupload-preview"></span>
									</div>
									<div class="input-group-btn">
										<div class="btn btn-default btn-file">
											<span class="fileupload-new"><i class="ico-folder"></i> Select file</span>
											<span class="fileupload-exists"><i class="ico-folder"></i> Change</span>
											<input type="file" class="file-input" name="userfile" id="_file">
										</div>
										<a href="#" class="btn btn-warning fileupload-exists" data-dismiss="fileupload">
											<i class="ico-remove"></i> Remove
										</a>
									</div>
								</div>
							</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<div class="col-sm-12">
							<label class="control-label">
								Caption / Keterangan
							</label>
							<input type="text" value="" name="caption" id="caption" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
					</div>
					<div class="col-md-4 fileupload-exists" data-dismiss="fileupload">
						<button type="submit" class="btn btn-primary btn-block" >
						Upload <i class="fa fa-arrow-circle-right"></i>
						</button>
					</div>
				</div>
				<?php if(isset($cover) && $cover):?>
					<input type="hidden" name="id_cover" value="<?php echo $cover['id'];?>"></input>
					
					<hr>
					<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<h4><?php echo $cover['caption']?></h4>
							<div class="thumbnail">
							<img src="<?php echo url().'/'.$cover['image']?>?<?php echo date('his');?>">
							</div>
						</div>
						<div class="col-md-3"></div>
					</div>
				<?php endif;?>
			</form>	
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="clip-arrow-right-2"></i>
			Headline Artikel
		</div>
		<form action="{{ url() }}/frontpage_setting/store" role="form" id="form" method="post">
			<input type="hidden" name="_token" id="_token" value="{{{ csrf_token() }}}" />
			
		<div class="panel-body">
			<a href="javascript:void(0)"  title="Tambah Headline" class="btn btn-info tooltips" id="_id_add"><i class="clip-plus-circle"></i> Tambah Headline</a>
			<hr>
			<div class="row" id="_list_headline">
				<?php if(isset($list_headline) && $list_headline):?>
					<?php foreach($list_headline as $row):?>
						<div id="_item_headline_<?php echo $row['id_article'];?>" style="overflow:hidden" class="col-md-4">
							<div class="thumbnail">
								<img alt="..." src="<?php echo url().'/'.$row['prev_img']?>">
									<div class="caption"><div class="text-center" style="height:50px;overflow:hidden">
									<h4><?php echo $row['title'];?></h4>
									</div>
									<br>
									<div class="row">	
										<div class="col-md-12 text-center">		
											<button onclick="remove_headline('<?php echo $row['id_article'];?>')" type="button" class="btn btn-danger  btn-sm">
												<i class="fa fa-times fa fa-white"></i> Hapus</button>	</div>
										</div>
									</div>
							<input type="hidden" class="class-article-id" value="<?php echo $row['id_article']?>" name="article_id[]">
							</div>
						</div>
					<?php endforeach;?>
				<?php else:?>
					<div class="col-md-12 text-center" id="_no_headline">
						<h4>Tidak ada headline yang ditambahkan...</h4>
					</div>
				<?php endif;?>
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
		</div>
		</form>
	</div>
</div>

<!-- js -->
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('/js/frontpage_setting.js')}}"></script>
<script src="{{ asset('/js/bootstrap-fileupload.min.js')}}"></script>
<script src="{{ asset('/js/perfect-scrollbar.js') }}"></script>

<link rel="stylesheet" href="{{ asset('/css/bootstrap-fileupload.min.css')}}">
@endsection
