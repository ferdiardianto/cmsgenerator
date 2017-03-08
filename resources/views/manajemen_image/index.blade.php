@extends('app')

@section('content')

<div class="container">
	<ol class="breadcrumb">
	  <li><a href="<?php url(); ?>/home">Home</a></li>
	  <li class="active">Manajemen Image</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-body">
			<input id='base_url' type="hidden" value="{{ url() }}/manajemen_image"></input>
			@if(Session::has('success'))
				<div class="alert alert-success alert-dismissible" role="alert">
	  				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  			{{ Session::get('success') }}
				</div>
			@endif

			@if(Session::has('error'))
				<div class="alert alert-danger alert-dismissible" role="alert">
	  				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  			<strong>Warning!</strong> {{ Session::get('error') }}
				</div>
			@endif
			<form action="{{ url() }}/manajemen_image/store" id="form" role="form" method="post" enctype="multipart/form-data">
				
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
								Masukan gambar 
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
											<input type="file" class="file-input" name="userfile" id="userfile">
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
						<button type="submit" class="btn btn-primary btn-block">
							Submit <i class="fa fa-arrow-circle-right"></i>
						</button>
					</div>
					<div class="col-md-8">					
					</div>
				</div>

			</form>
			<br>
			<br>
			

			<!-- datatables -->
			<table class="table table-striped table-bordered" id="data-table">
				<thead>
					<tr>
						<th>#Id</th>
						<th>Image</th>
						<th>Caption</th>
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
<script src="{{ asset('/js/manajemen_image.js')}}"></script>
<script src="{{ asset('/js/bootstrap-fileupload.min.js')}}"></script>

<!-- tambah ini -->
<script src="{{ asset('/ekstension/crooper/jquery.imgareaselect.min.js')}}"></script>
<link rel="stylesheet" href="{{ asset('/ekstension/crooper/css/imgareaselect-default.css')}}">
<link rel="stylesheet" href="{{ asset('/ekstension/crooper/css/imgareaselect-animated.css')}}">

<script>
//tambah ini
var imgArea="";
  $(function() {
    $("#userfile").on("change", function(a,b) {
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

<link rel="stylesheet" href="{{ asset('/css/bootstrap-fileupload.min.css')}}">
<link href="{{ asset('/css/dataTables.bootstrap.css') }}" rel="stylesheet">

@endsection
