@extends( 'layouts.master' )

@section( 'content' )

    <div class="container">
        
        <h1 class="page-header">Password Reset</h1>
        
    @if ( Session::get( 'error' ) )
    
        <div class="alert alert-danger">
            <strong>Error!</strong> {{ Session::get( 'error' ) }} <a href="/password/remind">Request another token.</a>
        </div>
        
    @endif
    
        <form action="/password/reset" method="post">
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="form-group">
                <label for="email" class="control-label">Email address</label>
                <input type="email" id="email" class="form-control" name="email">
            </div>
            
            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" id="password" class="form-control" name="password">
            </div>
            
            <div class="form-group">
                <label for="password_confirmation" class="control-label">Confirm Password</label>
                <input 
                    type="password" 
                    id="password_confirmation" class="form-control" 
                    name="password_confirmation"
                >
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
        <hr>
        
    </div>

@stop