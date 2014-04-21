@extends('layouts.master')

@section('content')

	<div class="jumbotron" style="margin-bottom: 0px">
		<div class="container">
			<div class="page-header">
				<a href="/">
					<img 
						src="static/img/bernly-logo.png" 
						width="200" 
						height="100" 
						class="center-block"
					>
				</a>
				<p class="lead text-center">Cut your links down to size.</p>
			</div>
			
			<form action="." method="post">
				<div class="input-group" style="font-size: 14px !important">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-link"></span>
					</span>
					
					<input 
						class="form-control input-lg"
						type="url" 
						name="long_url" 
						placeholder="Paste long link here"
					>
					
					<span class="input-group-btn">
						<button class="btn btn-success btn-lg" type="submit" name="submit" >
							Shorten
						</button>
					</span>
				</div>
			</form>
		</div>
	</div>
	
	@if ( isset( $short_url ) )
	
		<div class="container">
			<div class="page-header">
				<h3>Result
					<span class="pull-right">
						<strong>
							{{ Config::get('app.url_no_protocol') }}/{{ $short_url }}
						</strong>
					</span>
				</h3>
			</div>
		</div>
		
	@endif
@stop