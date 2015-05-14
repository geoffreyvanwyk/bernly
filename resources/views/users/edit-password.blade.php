@extends('layouts.master')

@section('content')

    <div class="container">
        <h1 class="page-header">Edit Password</h1>

        <form action="/user/edit-password" method="post" role="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group {{ Session::get('errors') ? 'has-error' : '' }}">
                <label class="control-label"
                    for="password"
                >New Password
                </label>

                <input class="form-control"
                    type="password" name="password" value="{{{ old('password') }}}"
                    id="password"
                >

                <p class="help-block">
                    {{ Session::get('errors') ? Session::get('errors')->first('password') : '' }}
                </p>
            </div>

            <div class="form-group {{ Session::get('errors') ? 'has-error' : '' }}">
                <label class="control-label"
                    for="password_confirmation"
                >Confirm new password
                </label>

                <input class="form-control"
                    type="password" name="password_confirmation" value="{{{ old('password') }}}"
                    id="password_confirmation"
                >

                <p class="help-block">
                    {{ Session::get('errors') ? Session::get('errors')->first('password') : '' }}
                </p>
            </div>

            <button class="btn btn-primary">Submit</button>

        </form>

        <hr>
    </div>

@endsection
