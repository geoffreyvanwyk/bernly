@extends( 'layouts.master')

@section( 'content' )
    
    <div class="container">
        
        <h1 class="page-header">Profile</h1>
        
    @if ( Session::get( 'is_edited' ) )
    
        <div class="alert alert-success">
           Your settings have been successfully updated! 
        </div>
    
    @endif
        
        <div class="row">
        
            <div class="col-sm-2">
                <span class="glyphicon glyphicon-envelope"></span>
                <strong> Email</strong> 
            </div>
            
            <div class="col-sm-4">
                {{{ Auth::user()->email }}}
            </div>
            
            <div class="col-sm-3">
                <a href="/user/edit-email" class="btn btn-info btn-xs">Edit</a>
            </div>
            
        </div>
        
        <div class="row">
        
            <div class="col-sm-2">
                <span class="glyphicon glyphicon-eye-close"></span>
                <strong> Password</strong> 
            </div>
            
            <div class="col-sm-4">
                &#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;
            </div>
        
            <div class="col-sm-3">
                <a href="/user/edit-password" class="btn btn-info btn-xs">Edit</a>
            </div>
            
        </div>
        
        <br>
        
        <a href="/user/remove" class="btn btn-danger">Delete</a>
        
    </div>
    
    <hr>
    
@stop