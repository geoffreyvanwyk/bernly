@extends( 'layouts.master')

@section( 'content' )
    
    <div class="container">
        
        <h1 class="page-header">Profile</h1>
        
        <div class="row">
        
            <div class="col-sm-3">
                <span class="glyphicon glyphicon-envelope"></span>
                <strong> Email address</strong> 
            </div>
            
            <div class="col-sm-3">
                {{{ Auth::user()->email }}}
            </div>
            
        </div>
        
        <div class="row">
        
            <div class="col-sm-3">
                <span class="glyphicon glyphicon-eye-close"></span>
                <strong> Password </strong> 
            </div>
            
            <div class="col-sm-3">
                &#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;
            </div>
        
        </div>
        
        <br>
        
        <a href="" class="btn btn-info">Edit</a>
        <a href="" class="btn btn-danger">Delete</a>
        
    </div>
    
    <hr>
    
@stop