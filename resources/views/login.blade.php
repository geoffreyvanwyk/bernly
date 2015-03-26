@extends( 'layouts.master' )

@section( 'content' )
	
	<div class="container">
	
		<h1 class="page-header">Login</h1>
		
    @if ( Session::get( 'error' ) )
    
        <div class="alert alert-danger">
            <strong>Authentication failed!</strong> Please try again.
        </div>
        
    @endif
        
		<form action="/log/in" method="post" role="form">
            <input 
                type="hidden" 
                name="_token" value="{{ csrf_token() }}" 
            >

			<div class="form-group">
				<label for="email" class="control-label">Email address</label>
				<input 
                    type="email" 
                    id="email" class="form-control" 
                    name="email"  value="{{{ Session::get( 'email' ) }}}"
                >
			</div>
			
			<div class="form-group">
				<label for="password" class="control-label">Password</label>
				<input 
                    type="password" 
                    id="password" class="form-control" 
                    name="password" value="{{{ Session::get( 'password' ) }}}"
                >
			</div>
			
			<div class="checkbox">
                <label for="remember_me" class="control-label">
                    <input type="checkbox" id="remember_me" name="remember_me"> Remember me
                </label>
			</div>
			
			<button class="btn btn-primary">Submit</button>
            <a href="/password/remind">Forgot password?</a>
		</form>
		
		<hr>
		
	</div>
	
@stop
