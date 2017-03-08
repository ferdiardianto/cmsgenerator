@extends('app')
@section('content')
<div class="container">
	<ol class="breadcrumb">
	  <li><a href="<?php url(); ?>/home">Home</a></li>
	  <li><a href="<?php url(); ?>/article">Artikel</a></li>
	  <li class="active">Edit Artikel</li>
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
							<form action="{{ url() }}/article/update" role="form" id="form" method="post">

							<input type="hidden"  class="form-control" id="id" name="id" value="{{ $Article->id }}">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            
								<div class="row">
									<div class="col-md-9">
										<div class="form-group">
											<label class="control-label">
												Judul <span class="symbol required"></span>
											</label>
											<input type="text"  class="form-control" id="title_article" name="title_article" value="{{ $Article->title }}">
										</div>

										<div class="form-group">
											<label class="control-label">
												Teaser <span class="symbol required"></span>
											</label>
											
											<textarea  name="teaser" class="form-control" id="teaser"><?php echo $Article->teaser; ?></textarea>
	
										</div>



										<div class="form-group">
											<div class="btn-group">
												<a id="_image_gallery" href="javascript:void(0)" class="btn btn-primary">
													<i class="clip-images-2"></i> Insert Image 
												</a>
											</div>
										</div>
										<div class="form-group">
											<textarea  name="content_article" class="autosize form-control" id="content_article" style="overflow: hidden; word-wrap: break-word; resize: horizontal;">
												<?php echo str_replace("../", url().'/', $Article->content); ?>
											</textarea>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label">
												Kategori 
											</label>
											<div id="_loader" style="display:none;"><img src="{{ asset('/images/ajax-loader.gif')}}" /></div>
											<select id="category_id" class="form-control" name="category_id">
												<?php
													foreach ($Category_article as $key => $row) {
														if($row->id==$Article->id_category){
															$selectarti = "selected='selected'";
														}else{
															$selectarti = "";
														}
												?>	
														<option <?php echo $selectarti; ?> value="<?php echo $row->id; ?>"><?php echo $row->category_name; ?></option>
												<?php
													}
												?>
												
											</select>
											
											
										</div>
										<div class="form-group">
											<label class="control-label">
												Status <span class="symbol required"></span>
											</label>
											 <select name="status" id="status" class="form-control">
												
												<?php
													if($Article->status==1){
												?>
														<option value="1" selected='selected'>Published</option>
														<option value="0">Unpublished</option>
												<?php
													}else{
												?>		
														<option value="1">Published</option>
														<option value="0" selected='selected'>Unpublished</option>
												<?php
													}
												?>

												
												
											 </select>
										</div>


										<div class="form-group">
											<label class="control-label">
												Tag (Hanya 1 Kata) <span class="symbol required"></span>
											</label>
											
											<?php
				                                 $tagging = explode("|", $Article->tag);
				                            ?>	

				                             <select id='tag' style="width:100%" name="tag[]"  multiple="multiple">
				                                <?php
				                                    foreach ($Tag as $row): 
				                                     
				                                        $key = array_search($row->name_tag, $tagging); 
				                                        if($key!== false){
				                                            $selectedx = 'selected';  
				                                        }else{
				                                            $selectedx = '';  
				                                        }
				                                ?>  
				                                        <option value="{{ $row->name_tag }}" <?php echo $selectedx; ?> >{{ $row->name_tag }}</option>
				                                <?php
				                                    endforeach;
				                                ?>
				                            </select>									
	
										</div>

										<div class="form-group">
											<input type="checkbox" id="status_schedule" name="status_schedule" value="2"> Schedule<br>
										</div>

										<div id="buatdateschedule" class="form-group">
										
											 <div id="datetimepicker1" class="input-append date">
											    <input data-format="yyyy-MM-dd hh:mm:ss" type="text"  class="form-control" id="date_schedule" name="date_schedule" value="<?php echo $Article->date_schedule; ?>"></input>
											    <span class="add-on">
											      <i data-time-icon="glyphicon glyphicon-time" data-date-icon="glyphicon glyphicon-calendar">
											      </i>
											    </span>
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
					<!-- end: FORM VALIDATION 1 PANEL -->
				</div>
				</div>


				<div id="gallery-modal" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog big">
						<div class="modal-content">
						<div class="modal-body" style="padding-bottom:0px;">
						  <iframe   frameborder="0"  height="470" width="100%" src="<?php echo url(); ?>/image_manager"></iframe>
						</div>
						<div class="modal-footer" style="margin-top:0px;">
							<button class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
						</div>
					</div>
				</div>

        </div>
    </div>   
</div>

<!-- js and css -->
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('/ekstension/tinymce/js/tinymce/tinymce.min.js')}}"></script>
<script src="{{ asset('/js/article_form.js')}}"></script>

<script src="{{ asset('/js/select2.min.js')}}"></script>

<link href="{{ asset('/css/select2.css') }}" rel="stylesheet">


<!-- date time -->
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js')}}"></script>
<link href="{{ asset('/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">

<script type="text/javascript">
  $(function() {
    $('#datetimepicker1').datetimepicker({
      language: 'pt-BR'
    });
  });
</script>

<?php
	if($Article->status==1 || $Article->status==0){
		//javascript hidden dan unchek
?>
		<script>
			$('#status_schedule').prop('checked', false);
    		$('#buatdateschedule').hide();
		</script>
<?php
	}else{
		// javacript show dan check
?>
		<script>
			$('#status_schedule').prop('checked', true);
    		$('#buatdateschedule').show();
		</script>
<?php
	}
?>



<style>
textarea.autosize {
    transition: height 0.2s ease 0s;
    vertical-align: top;
}
</style>

@endsection