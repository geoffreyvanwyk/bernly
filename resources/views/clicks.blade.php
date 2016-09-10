@extends( 'layouts.master' )

@section( 'content' )

<div class="container">
    <h1 class="page-header">Clicks</h1>

    <form class="form-horizontal" role="form">
        <div class="form-group">
            <label class="control-label col-sm-2" for="long_link">Long Link</label>
            <div class="col-sm-10">
                <p class="form-control-static" id="long_link">{{ $url['long_url'] }}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="short_link">Short Link</label>
            <div class="col-sm-10">
                <p class="form-control-static" id="short_link">
                    {{ config('app.url_short') }}/{{ $url['short_url'] }}
                </p>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="created_at">Date Created</label>
            <div class="col-sm-10">
                <p class="form-control-static" id="created_at">{{ $url['created_at'] }}</p>
            </div>
        </div>
    </form>

    <table class="table table-condensed">
        <thead>
            <th>Referer</th>
            <th>When</th>
        </thead>

        <tbody>

@if ( count( $url['hits'] ) > 0 )
    @foreach ( $url['hits'] as $hit )

            <tr>
                <td>{{ $hit['referer'] }}</td>
                <td>{{ $hit['created_at'] }}</td>
            </tr>

    @endforeach
@else

    <tr>
        <td colspan="2">
            <div class="alert alert-info">
                <p class="text-center">The link has not been clicked yet.</p>
            </div>
        </td>
    </tr>

@endif

        </tbody>
    </table>
</div>

@stop
