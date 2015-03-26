@extends( 'layouts.master' )

@section( 'content' )
    
    <div class="container">
    
        <h1 class="page-header">Email Verification</h1>
        
    @if ( $success )
    
        <div class="alert alert-success">
            <strong>Thank you!</strong> Your email address has been verified. You can now use the advanced features.
        </div>
    
    @else
    
        <div class="alert alert-danger">
            <strong>Error!</strong> The email verification failed. 
        </div>
    
    @endif
    
    </div>
    
@stop
