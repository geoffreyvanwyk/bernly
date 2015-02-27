@extends( 'layouts.master' )

@section( 'content' )
    
    <div class="container">
    
        <h1 class="page-header">Password Reminder</h1>
        
    @if ( Session::get( 'status' ) )
    
        <div class="alert alert-success">
            {{ Session::get( 'status' ) }}
        </div>
        
    @elseif ( Session::get( 'error' ) )
    
        <div class="alert alert-danger">
            {{ Session::get( 'error' ) }}
        </div>
        
    @else
    
        <div class="alert alert-info">
            Please enter the email address with which you registered your account.
        </div>
        
    @endif
    
    @if ( ! Session::get( 'status' ) )
        
        <form action="/password/remind" method="post">
            <div class="form-group">
                <label for="email" class="control-label">Email address</label>
                <input type="email" id="email" class="form-control" name="email">
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
     
    @endif
        
        <hr>
        
    </div>
    
@stop