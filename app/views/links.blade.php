@extends( 'layouts.master' )

@section( 'content' )

<div class="container">
    <h1 class="page-header">Your Links</h1>
    
    <table class="table table-condensed">
        <thead>
            <th>Long Link</th>
            <th>Short Link</th>
            <th>Created</th>
            <th class="text-center">Clicks</th>
            <th>&nbsp;</th>
        </thead>
        
        <tbody>
        
        @foreach ( $urls as $url )
        
            <tr>
                <td>{{ $url['long_url'] }}</td>
                <td>{{ Config::get( 'app.url_no_protocol' ) }}/{{ $url['short_url'] }}</td>
                <td>{{ $url['created_at'] }}</td>
                <td class="text-center">{{ $url['hits'] }}</td>
                <td><a href="#">Details</a></td>
            </tr>
        
        @endforeach
        
        </tbody>
    </table>
</div>

@stop