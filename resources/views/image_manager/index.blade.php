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
		<!-- end: MAIN CSS -->
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body style="background-color:#F0F0F0">
	<input type="hidden" name="_token" id="_token" value="{{{ csrf_token() }}}" />
	<div class="container" id="_list_content">
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
							<form method="get" action="<?php echo url(); ?>/image_manager" class="form-horizontal">
								<div class="input-group">
									<input type="text" placeholder="Cari foto" class="form-control" name="q" id="querycari">
									<span class="input-group-btn">
										<button type="submit" class="btn btn-info">Cari</button>
									</span>
								</div>
							</form>
						</div>
						<div class="col-md-6">
							<a href="<?php echo url(); ?>/image_manager/upload_image"  title="Upload Image" class="btn btn-info tooltips pull-right"><i class="ico-plus-circle"></i> Upload Image</a>
						</div>
						</div>
					</div>
				</div>
			</div>
			</div>
			
		<?php if(isset($image_list)):?>
			<?php $i=0;?>
			<?php foreach($image_list as $row):?>
			<?php $i++;?>
			
			<?php if($i !=1 && $i%6==1):?>
				</div>
				<div class="row">
			<?php endif;?>
			<?php if($i==1):?>
			<div class="row" style="margin-top:80px">
			<?php endif;?>

			<div class="col-md-2"  data-date-created="<?php echo $row['created_at']?>" data-title="background3" style="overflow:hidden">
					<div class="thumbnail">
						<img src="<?php echo url().'/'.$row['img_preview']?>" alt="...">
						<div class="caption">
						<div style="height:20px;overflow:hidden">
							<?php echo (($row['caption'])?$row['caption']:'-')?>
						</div>
						<p>
						<small class="text-muted"><?php echo $row['created_at']?></small>
						</p>
						<div class="row">
							<div class="col-md-12 text-center">
							<button class="btn btn-info  btn-xs" type="button" onclick="window.parent.insert_image('<?php echo $row['id']?>','<?php echo url().'/'.$row['img_preview']?>','<?php echo $row['img_origin']?>')"><i class="ico-check"></i> Pilih</button>
							</div>
						</div>
						</div>
					</div>
				</div>			
			
			<?php endforeach;?>
			<?php if($i !=0):?>
				</div>
			<?php endif;?>
			<?php endif;?>		
			
			
	</div>
	
	<?php if($pagging):?>

		<div class="row-fluid" style="margin:10px;">
				<a class="btn btn-primary btn-sm btn-block" href="<?php echo $pagging;?>" style="margin-top:5px" id="_load_more">
					Load More
				</a>
				<center style="display:none;" id="_loader"><img src="<?php echo url();?>/images/ajax-loader.gif"  /> &nbsp;</center>
				<br>
				
		</div>

	<?php endif;?>
	

<script src="{{ asset('/js/jquery.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/js/perfect-scrollbar.js') }}"></script>
</body>
<!-- end: BODY -->
<script type="text/javascript">
	<?php
		if(isset($_GET['q'])){
			$qcari = $_GET['q'];
		}else{
			$qcari = "";
		}
	?>
	var _token 		= $('#_token').val();
	var querycari 	= "<?php echo $qcari; ?>";

	$(document).ready(function(){
		$("#_load_more").click(function(){
			$("#_load_more").hide();
			$("#_loader").show();
			
			$.ajax({
				url: $(this).attr('href'),
				type: 'POST',
				data: {_token:_token,q:querycari},
				datatype:'json',
				success: function (data) {
				jsondata=$.parseJSON(data);
					$("#_list_content").append(jsondata.view);
					if(jsondata.pagging){
						$("#_load_more").attr('href',jsondata.pagging);
					}else{
						$("#_load_more").remove();
					}
					$("#_loader").hide();
					$("#_load_more").show();
				}
			});
			
			return false;
		})
		
	})
</script>
</html>