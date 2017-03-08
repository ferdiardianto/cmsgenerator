<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>My Cms</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href="{{ asset('/css/font.css') }}" rel='stylesheet' type='text/css'>

	<!-- jquery -->
	<script src="{{ asset('/js/jquery.min.js')}}"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/')}}">My Cms</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">

					@if (!Auth::guest())
						<li class="<?php if(isset($act_menu) && $act_menu=='Home') echo 'active'?>"><a href="{{ url('/home') }}">Home</a></li>
						<?php
							$value = Session::get('id_microsite');
							if($value!=""){
								$user_data = Session::get('user_data');
								$hak_akses=explode("|",$user_data[0]['hak_akses']);
						?>
								<li class="dropdown <?php if(isset($parent_menu) && $parent_menu=='Pengaturan') echo 'active'?>">
					            	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Pengaturan <b class="caret"></b></a>
					            	<ul class="dropdown-menu">
					            		<?php if(array_search('profile_setting',$hak_akses) !==FALSE): ?>
					            			<li class="<?php if(isset($act_menu) && $act_menu=='profile_setting') echo 'active'?>"><a href="{{ url('/profile_setting') }}">Profil</a></li>
					            		<?php endif;?>

					            		<?php if(array_search('frontpage_setting',$hak_akses) !==FALSE): ?>
					            			<li class="<?php if(isset($act_menu) && $act_menu=='frontpage_setting') echo 'active'?>"><a href="{{ url('/frontpage_setting') }}">Cover dan Headline</a></li>
					            		<?php endif;?>
					            		
										<!-- masih salah -->
					            		<?php if(array_search('article_editor',$hak_akses) !==FALSE): ?>
					            			<li class="<?php if(isset($act_menu) && $act_menu=='article_editor') echo 'active'?>"><a href="{{ url('/article_editor') }}">Editor Choice</a></li>
					            		<?php endif;?>

					            	</ul>
					        	</li> 
					        	<li class="dropdown <?php if(isset($parent_menu) && $parent_menu=='Posting') echo 'active'?>">
					            	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Posting <b class="caret"></b></a>
					            	<ul class="dropdown-menu">
					            		<?php if(array_search('category_article',$hak_akses) !==FALSE): ?>
					            			<li class="<?php if(isset($act_menu) && $act_menu=='category_posting') echo 'active'?>"><a href="{{ url('/category_article') }}">Kategori</a></li>
										<?php endif;?>

					            		<?php if(array_search('article',$hak_akses) !==FALSE): ?>
					            			<li class="<?php if(isset($act_menu) && $act_menu=='article') echo 'active'?>"><a href="{{ url('/article') }}">Artikel</a></li>
					            		<?php endif;?>
					            	</ul>
					        	</li> 

					        	<li class="dropdown <?php if(isset($parent_menu) && $parent_menu=='Galeri') echo 'active'?>">
					            	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Galeri <b class="caret"></b></a>
					            	<ul class="dropdown-menu">
					            		<?php if(array_search('image_gallery',$hak_akses) !==FALSE): ?>
					            			<li class="<?php if(isset($act_menu) && $act_menu=='image_gallery') echo 'active'?>"><a href="{{ url('/image_gallery') }}">Image</a></li>
										<?php endif;?>

					            		<?php if(array_search('video_gallery',$hak_akses) !==FALSE): ?>
					            			<li class="<?php if(isset($act_menu) && $act_menu=='video_gallery') echo 'active'?>"><a href="{{ url('/video_gallery') }}">Video</a></li>
					            		<?php endif;?>
					            	</ul>
					        	</li> 

					        	<li class="dropdown <?php if(isset($parent_menu) && $parent_menu=='Manajemen User') echo 'active'?>">
					            	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Manajemen User <b class="caret"></b></a>
					            	<ul class="dropdown-menu">
					            		<?php if(array_search('group_user',$hak_akses) !==FALSE): ?>
					            			<li class="<?php if(isset($act_menu) && $act_menu=='group_user') echo 'active'?>"><a href="{{ url('/group_user') }}">Group User</a></li>
										<?php endif;?>

					            		<?php if(array_search('user',$hak_akses) !==FALSE): ?>
					            			<li class="<?php if(isset($act_menu) && $act_menu=='admin_user') echo 'active'?>"><a href="{{ url('/user') }}">Data User</a></li>
										<?php endif;?>
					            	</ul>
					        	</li> 
					        	
								<?php if(array_search('manajemen_image',$hak_akses) !==FALSE): ?>
						        	<li class="<?php if(isset($act_menu) && $act_menu=='manage_image') echo 'active'?>">
						        		<a href="{{ url('/manajemen_image') }}">Manajemen Image</a>
						        	</li>
						        <?php endif;?>
                </ul>			
            </li> 
						<?php
							}
						?>
					@endif

					
					
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						
							<li><a href="{{ url('/auth/login') }}">Masuk</a></li>
						<!--
							<li><a href="{{ url('/auth/register') }}">Register</a></li>
						-->
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">Keluar</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	<!-- Scripts -->
	<script src="{{ asset('/js/bootstrap.min.js')}}"></script>
</body>
</html>
