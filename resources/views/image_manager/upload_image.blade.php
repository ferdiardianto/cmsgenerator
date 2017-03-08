<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title>Image Manager</title>
		<!-- start: META -->
		<meta charset="utf-8" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- end: META -->

		<!-- start: MAIN CSS -->
		<link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('/css/main.css') }}">
		<link rel="stylesheet" href="{{ asset('/css/perfect-scrollbar.css') }}">
		<link rel="stylesheet" href="{{ asset('/css/bootstrap-fileupload.min.css') }}">
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body style="background-color:#F0F0F0">
	<div class="container">
	<div class="row-fluid">
		<div class="col-md-12 navbar-fixed-top">
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
					<div class="col-md-6">
						<h4>Upload Image</h4>
					</div>
					<div class="col-md-6">
						<a href="<?php echo url(); ?>/image_manager"  title="Galeri Image" class="btn btn-info tooltips pull-right"><i class="ico-images"></i> Galeri Image</a>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid" style="margin-top:80px">
		<div class="panel panel-default">
			<div class="panel-body">
				<form method="post" action="<?php echo url(); ?>/image_manager/store" class="form-horizontal" enctype="multipart/form-data">
				<!-- tambah ini -->
				<input type="hidden" id="img_x1" name="img_x1" value="0">
				<input type="hidden" id="img_y1" name="img_y1" value="0">
				<input type="hidden" id="img_x2" name="img_x2" value="390">
				<input type="hidden" id="img_y2" name="img_y2" value="195">

				<input type="hidden" name="_token" id="_token" value="{{{ csrf_token() }}}" />
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<div class="col-sm-12">
							<label class="control-label">
								Masukan gambar <!--span class="text-muted">(Lebar minimal : 780px)</span-->
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
											<input type="file" class="file-input" name="userfile" id="file">
										</div>
										<a href="#" class="btn btn-warning fileupload-exists" data-dismiss="fileupload">
											<i class="ico-remove"></i> Remove
										</a>
									</div>
								</div>
							</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
							<label class="control-label">
								Author
							</label>
							<input type="text" value="" name="author" id="author" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
							<label class="control-label">
								Caption / Keterangan
							</label>
							<input type="text" value="" name="caption" id="caption" class="form-control">
							</div>
						</div>
					</div>

					<!-- tambah ini -->
					<div class="col-sm-6">
						<div class="form-group">
							<div class="col-sm-12">
								<div id="div_radio" style="display:none">
								<label class="control-label">
									<input type="radio" name="type_img" value="1" checked="checked" id="radio_crop"/> Potong gambar
								</label>
								<label class="control-label">
									<input type="radio" name="type_img" value="2" id="radio_proporsional"/> Proporsional
								</label>
								<hr>
								</div>
								<div style="border:1px solid #CCC;width:392px;min-height:197px;z-index:999;text-align:center" id="id_frame">
									<img id="img_frame" src="<?php echo url(); ?>/images/no-image.jpg" border="0" style="width:100%"/>
								</div>
							</div>
						</div>
					</div>

				</div>
				<hr>
				<div class="row">
					<div class="col-md-4">
						<button type="submit" class="btn btn-yellow btn-block">
							Submit <i class="fa fa-arrow-circle-right"></i>
						</button>
					</div>
					<div class="col-md-8">					
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
	</div>

	<script src="{{ asset('/js/jquery.min.js') }}"></script>
	<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/js/perfect-scrollbar.js') }}"></script>
	<script src="{{ asset('/js/bootstrap-fileupload.min.js') }}"></script>

	<!-- tambah ini -->
	<script src="{{ asset('/ekstension/crooper/jquery.imgareaselect.min.js')}}"></script>
	<link rel="stylesheet" href="{{ asset('/ekstension/crooper/css/imgareaselect-default.css')}}">
	<link rel="stylesheet" href="{{ asset('/ekstension/crooper/css/imgareaselect-animated.css')}}">


	<script>
		//tambah ini
		var imgArea="";
		  $(function() {
		    $("#file").on("change", function(a,b) {
		      readImage(this);
		    });

		    $("#radio_crop").click(function(){
		        $("#img_frame").css({"height":"auto","width":"390"});
		        imgArea=$('#id_frame').imgAreaSelect({
		          instance:true,
		          // aspectRatio:"9:16",
		          handles: true,
		          show:true,
		          minHeight:195,
		          minWidth:390,
		          maxHeight:195,
		          maxWidth:390,
		          onSelectEnd: function (img, selection){
		            // alert('width: ' + selection.width + '; height: ' + selection.height);
		            $("#img_x1").val(selection.x1);
		            $("#img_y1").val(selection.y1);
		            $("#img_x2").val(selection.x2);
		            $("#img_y2").val(selection.y2);
		          }
		        });
		        imgArea.setSelection(0, 0, 390, 195, true);
		        imgArea.update();
		    })
		    
		    $("#radio_proporsional").click(function(){
		      // alert(0);
		      $("#img_frame").css({"height":"195px","width":"auto"});
		      imgArea.cancelSelection();
		    })
		  });
		  
		  function readImage(input) {
		    // console.log(input.files[0]);
		    
		    if ( input.files && input.files[0]){
		      if(input.files[0]['type']=='image/jpeg' || input.files[0]['type']=='image/jpg' || input.files[0]['type']=='image/png' || input.files[0]['type']=='image/gif'){
		        if(input.files[0]['size'] > 1048576){
		          alert('Ukuran file terlalu besar..'); 
		        }
		        var FR= new FileReader();
		        FR.onload = function(e) {
		          $('#img_frame').attr( "src", e.target.result );
		          $("#radio_crop").click();
		        };       
		        FR.readAsDataURL( input.files[0] ); 
		        $("#div_radio").show();
		      }else{
		        alert('Format file tidak sesuai...');
		        return false;
		      }
		      
		    }else{
		      $('#img_frame').attr( "src",'<?php echo url(); ?>/images/no-image.jpg');
		      imgArea.cancelSelection();
		      $("#div_radio").hide();
		    }
		    
		  }
		</script>
	

</body>
<!-- end: BODY -->
</html>