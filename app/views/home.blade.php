@extends( 'layouts.master' )

@section( 'content' )

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
	
	@if ( Session::get( 'short_url' ) )
	
		<div class="container">
			<div class="page-header">
				<h3>Result
					<span class="pull-right">
						<strong>
							{{ Config::get( 'app.url_no_protocol' ) }}/{{ Session::get( 'short_url' ) }}
						</strong>
					</span>
				</h3>
			</div>
		</div>
		
	@endif
	
	@if ( ! Auth::check() )
	
	    <div class="jumbotron">
			<div class="container">
				<h1>Register for advanced features!</h1>
				
				<div class="row">
					<div class="col-md-4">
						<h2>Save your links</h2>
						<p>Come back at any time to see the links you have shortened before, and the corresponding shorter links.</p>
					</div>
					
					<div class="col-md-4">
						<h2>Tracking</h2>
						<p>See on which web sites your links have been clicked, and how many times they have been clicked.</p>
					</div>
					
					<div class="col-md-4">
						<h2>$10</h2>
						<p>per month</p>
					</div>
				</div>
				
				<p><a class="btn btn-primary btn-lg" role="button">Register Now &raquo;</a></p>
			</div>
		</div>
	
	@endif
	
@stop