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
				<div class="panel-heading">Buat Website Baru</div>

				<div class="panel-body">
					<h1>Website Baru</h1>
				    {!! Form::open(['url' => 'home/do_save_microsite']) !!}
				    <div class="form-group">
				        {!! Form::label('Nama Website', 'Nama Website:') !!}
				        {!! Form::text('website_name',null,['class'=>'form-control', 'required' => '']) !!}
				    </div>
				    <div class="form-group">
				        {!! Form::label('Sub Domain', 'Sub Domain:') !!}
				        {!! Form::text('subdomain',null,['class'=>'form-control', 'required' => '']) !!}
				    </div>
				    <div class="form-group">
				        {!! Form::label('Slogan', 'Author:') !!}
				        {!! Form::text('slogan',null,['class'=>'form-control', 'required' => '']) !!}
				    </div>
				    <div class="form-group">
				        {!! Form::label('Author', 'Publisher:') !!}
				        {!! Form::text('author',null,['class'=>'form-control', 'required' => '']) !!}
				    </div>
				    <div class="form-group">
				        {!! Form::label('Email', 'Email:') !!}
				        {!! Form::email('email',null,['class'=>'form-control', 'required' => '']) !!}
				    </div>
				    <div class="form-group">
				        {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
				    </div>
				    {!! Form::close() !!}
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
