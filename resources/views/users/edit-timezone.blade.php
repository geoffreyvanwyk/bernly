@extends( 'layouts.master' )

@section( 'content' )

<div class="container">
    <form action="/user/edit-timezone" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group {{ Session::get( 'timezone_class' ) }}">
            <label class="control-label" for="timezone">Timezone</label>
            <select class="form-control" id="timezone" name="timezone">
                <option>Please select ...</option>
            
            @foreach ( $timezones as $timezone )
            
                <option value="{{ $timezone }}">{{ $timezone }}</option>
            
            @endforeach
            
            </select>
            <p class="help-block">{{ Session::get( 'timezone_error' ) }}</p>
        </div>
        
        <button class="btn btn-primary">Submit</button> 
    </form>
</div>

@stop
