@extends('layouts.master')

@section('content')

    <div class="container">
        <form action="/user/edit-timezone" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group {{ Session::get('errors') ? 'has-error' : '' }}">
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

            <button class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection
