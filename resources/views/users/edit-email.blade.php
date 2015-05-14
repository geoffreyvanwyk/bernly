@extends( 'layouts.master' )

@section( 'content' )

    <div class="container">
    
        <h1 class="page-header">Edit Email</h1>
    
        <form action="/user/edit-email" method="post" role="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
            <div class="form-group {{ Session::get( 'email_class' ) }}">
                <label for="email" class="control-label">Email address</label>
                <input 
                    type="text" 
                    id="email" class="form-control" 
                    name="email" value="{{{ Session::get( 'email' ) }}}"
                >
                <p class="help-block">{{ Session::get( 'email_error' ) }}</p>
            </div>
        
            <button class="btn btn-primary">Submit</button>
            
        </form>
        
        <hr>
        
    </div>
    
@stop
