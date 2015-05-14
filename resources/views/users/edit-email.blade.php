@extends( 'layouts.master' )

@section( 'content' )

    <div class="container">
        <h1 class="page-header">Edit Email</h1>

        <form action="/user/edit-email" method="post" role="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group {{ Session::get('errors') ? 'has-error' : '' }}">
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

            <button class="btn btn-primary">Submit</button>
        </form>

        <hr>
    </div>

@endsection
