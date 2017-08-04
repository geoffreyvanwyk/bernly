@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-danger">
                <div class="panel-heading">404 - Not Found</div>
                <div class="panel-body">
                    A link for the {{ env('APP_SHORT_DOMAIN') }} URL you clicked, does not exist.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
