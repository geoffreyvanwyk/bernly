@extends('layouts.master')

@section('content')

    <div class="container">
        <h1 class="page-header">Register</h1>

        <form action="/user/add" method="post" role="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

        @if (Session::get('errors'))

            <div class="form-group {{ Session::get('errors')->has('email') ? 'has-error' : '' }}">

        @else

            <div class="form-group">

        @endif

                <label class="control-label"
                    for="email"
                >Email address
                </label>

                <input class="form-control"
                    type="email" name="email" value="{{{ old('email') }}}"
                    id="email"
                >

                <p class="help-block">
                    {{ Session::get('errors') ? Session::get('errors')->first('email') : '' }}
                </p>
            </div>

        @if (Session::get('errors'))

            <div class="form-group {{ Session::get('errors')->has('password') ? 'has-error' : '' }}">

        @else

            <div class="form-group">

        @endif

                <label class="control-label"
                    for="password"
                >Password
                </label>

                <input class="form-control"
                    type="password" name="password" value="{{{ old('password') }}}"
                    id="password"
                >

                <p class="help-block">
                    {{ Session::get('errors') ? Session::get('errors')->first('password') : '' }}
                </p>
            </div>

        @if (Session::get('errors'))

            <div class="form-group {{ Session::get('errors')->has('password') ? 'has-error' : '' }}">

        @else

            <div class="form-group">

        @endif
                <label class="control-label"
                    for="password_confirmation"
                >Confirm password
                </label>

                <input class="form-control"
                    type="password" name="password_confirmation" value="{{{ old('password_confirmation') }}}"
                    id="password_confirmation"
                >

                <p class="help-block">
                    {{ Session::get('errors') ? Session::get('errors')->first('password') : '' }}
                </p>
            </div>


        @if (Session::get('errors'))

            <div class="form-group {{ Session::get('errors')->has('timezone') ? 'has-error' : '' }}">

        @else

            <div class="form-group">

        @endif
                <label class="control-label"
                    for="timezone"
                >Timezone
                </label>

                <select class="form-control"
                    id="timezone" name="timezone"
                >
                    <option value="{{{ old('timezone') }}}">
                        {{{ old('timezone') }}}
                    </option>

                    @foreach ($timezones as $timezone)

                        <option value="{{ $timezone }}">{{ $timezone }}</option>

                    @endforeach

                </select>
                <p class="help-block">
                    {{ Session::get('errors') ? Session::get('errors')->first('timezone') : '' }}
                </p>
            </div>

            <div class="form-group {{ Session::get( 'recaptcha_class' ) }}">
                <div id="recaptcha-tag" ></div>
                <p class="help-block">{{ Session::get( 'recaptcha_error' ) }}</p>
            </div>

            <button class="btn btn-primary" disabled>Submit</button>

        </form>

        <hr>

    </div>

@endsection

@section( 'scripts' )
    <script>
        var recaptcha_site_key = "{{ env('RECAPTCHA_SITE_KEY') }}";
    </script>
    <script src="{{ Illuminate\Support\Facades\URL::asset( 'static/js/recaptcha.js' ) }}"></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

@endsection

