@extends( 'layouts.master')

@section( 'content' )
    
<div class="container">
    <h1 class="page-header">Profile</h1>
    
@if ( Session::get( 'is_edited_email' ) )

    <div class="alert alert-success">
        <strong>Success!</strong> Your email address has been successfully updated! 
    </div>

@endif
    
@if ( Session::get( 'is_edited_password' ) )

    <div class="alert alert-success">
        <strong>Success!</strong> Your password has been successfully updated! 
    </div>

@endif

@if ( Session::get( 'is_resent' ) )

    <div class="alert alert-info">
        <strong>Info!</strong> The email message containing the verification link has been resent. 
    </div>
    
@endif

@if ( ! Auth::user()->verified )

    <div class="alert alert-warning">
        <strong>Warning!</strong> Your email address has not been verified yet. 
        <br>
        An email message has been sent to you. Please click the verification link in the message to verify 
        your email address. 
        <br>
        If you have not received the email, <a href="/verify?resent=true">request that it be resent.</a>
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
    
    <hr>
</div>
    
@stop