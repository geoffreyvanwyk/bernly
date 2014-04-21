@extends( 'layouts.master' )

@section( 'content' )

	<div class="container">
	
		<h1 class="page-header">New User</h1>
	
		<form action="/user/register" method="post" role="form">
		
			<div class="form-group">
				<label for="email">Email address</label>
				<input type="email" id="email" class="form-control" name="email">
			</div>
			
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" id="password" class="form-control" name="password">
			</div>
			
			<div class="form-group">
				<label for="confirm_password">Confirm Password</label>
				<input type="password" id="confirm_password" class="form-control" name="confirm_password">
			</div>
			
			<button class="btn btn-primary">Register</button>
			
		</form>
		
		<hr>
		
	</div>
	
@stop