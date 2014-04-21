@extends( 'layouts.master' )

@section( 'content' )

	<form action="user/login" method="post">
		<label for="email" class="control-label">Email</label>
		<input type="email" name="email" id="email" class="form-control">
		
		<label for="password" class="control-label">Password</label>
		<input type="password" name="password" id="password" class="form-control">
	</form>
	
@stop