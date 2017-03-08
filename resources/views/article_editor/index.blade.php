@extends('app')

@section('content')
<div class="container">
	<ol class="breadcrumb">
	  <li><a href="<?php url(); ?>/home">Home</a></li>
	  <li class="active">Edior Choice</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="clip-arrow-right-2"></i>
			Edior Choice
		</div>
			<input id='base_url' type="hidden" value="{{ url() }}/article_editor">
		
		<form action="{{ url() }}/article_editor/store" role="form" id="form" method="post">
			<input type="hidden" name="_token" id="_token" value="{{{ csrf_token() }}}" />
			
		<div class="panel-body">
			<a href="javascript:void(0)"  title="Tambah Headline" class="btn btn-info tooltips" id="_id_add"><i class="clip-plus-circle"></i> Tambah Editor Choice</a>
			<hr>
			<div class="row" id="_list_headline">
				<?php if(isset($list_editorchoice) && $list_editorchoice):?>
					<?php foreach($list_editorchoice as $row):?>
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
						<h4>Tidak ada Editor Choice yang ditambahkan...</h4>
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
<script src="{{ asset('/js/article_editor.js')}}"></script>
<script src="{{ asset('/js/perfect-scrollbar.js') }}"></script>
@endsection
