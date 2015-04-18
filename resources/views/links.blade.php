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

    @if ( ! empty( $urls ) )
        @foreach ( $urls as $url )

            <tr>
                <td>{{ $url['long_url'] }}</td>
                <td>{{ env( 'APP_URL_SHORT' ) }}/{{ $url['short_url'] }}</td>
                <td>{{ $url['created_at'] }}</td>
                <td class="text-center">{{ $url['hits'] }}</td>
                <td><a href="/user/link/{{ $url['id'] }}">Details</a></td>
            </tr>

        @endforeach
    @else

        <tr>
            <td colspan="4">
                <div class="alert alert-info">
                    <p class="text-center">You do not have any links yet.</p>
                </div>
            </td>
        </tr>

    @endif

        </tbody>
    </table>
</div>

@stop
