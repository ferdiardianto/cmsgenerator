@extends('app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
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
				<div class="panel-heading">Informasi</div>

				<div class="panel-body">
					
			        <div class="row">
						<div class="col-lg-6 text-left">
							
	                		<!-- drop down -->
	                		<select id='cmbmicrosite' onchange='changemicrosite(this.value)' class="form-control">
	                			<option value="">-- Pilih Website --</option>
		                		<?php
		                			foreach ($Microsite as $row):
		                				if($id_microsite==$row['id']){
		                					$selected='selected="selected"';
		                				}else{
		                					$selected='';
		                				}
								?>	
										<option value="{{ $row['id'] }}" {{$selected}}>{{ $row['website_name'] }}</option>
		                		<?php
		                			endforeach;
		                		?>
	                		</select>
	                		
	            		</div>
			            <div class="col-lg-6 text-left">
			            	<input id='base_url' type="hidden" value="{{ url() }}/home"></input>
			            	<input id='_token' type="hidden" name="_token" value="{{{ csrf_token() }}}" />
			            	<form action='{{ url() }}/home/create_microsite'>
			                	<button type="submit" class="btn btn-primary" >Buat Website Baru</button>
			            	</form>
			            </div>
			        </div>
						


				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{ asset('/js/home.js')}}"></script>
@endsection
