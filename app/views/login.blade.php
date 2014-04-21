@extends( 'layouts.master' )

@section( 'content' )
	
	<div class="container">
	
		<h1 class="page-header">Login</h1>
	
		<form action="/user/login" method="post" role="form">
		
			<div class="form-group">
				<label for="email">Email address</label>
				<input type="email" id="email" class="form-control" name="email">
			</div>
			
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" id="password" class="form-control" name="password">
			</div>
			
			<button class="btn btn-primary">Login</button>
			
		</form>
		
		<hr>
		
	</div>
	
@stop