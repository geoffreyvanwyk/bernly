@extends( 'layouts.master' )

@section( 'content' )

<div class="container">
    <div class="jumbotron">
        <form action="." method="post">
            <div class="input-group" style="font-size: 14px !important">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-link"></span>
                </span>
                
                <input 
                    class="form-control input-lg"
                    type="url" 
                    name="long_url" 
                    placeholder="Paste long link here"
                >
                
                <span class="input-group-btn">
                    <button class="btn btn-success btn-lg" type="submit" name="submit" >
                        Shorten
                    </button>
                </span>
            </div>
        </form>
    </div>
</div>

@if ( Session::get( 'short_url' ) )

<div class="container" >
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">Result</h3>
        </div>
        
        <table class="table table-condensed" >
            <thead>
                <th>Short Link</th>
                <th>Length</th>
            </thead>
            
            <tbody>
                <tr>
                    <td>{{ Session::get( 'short_url' ) }}</td>
                    <td class="text-center" style="width: 15px">{{ strlen( Session::get( 'short_url' ) ) }}</td>
                </tr>
            </tbody>
        </table>
        
        <table class="table table-condensed">
            <thead>
                <th>Long Link</th>
                <th>Length</th>
            </thead>
            
            <tbody>
                <tr>
                    <td >{{ Session::get( 'long_url' ) }}</td>
                    <td class="text-center" style="width: 15px">{{ strlen( Session::get( 'long_url' ) ) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
    
@endif

@if ( ! empty( $urls ) )

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Your Recent Links with Clicks</h3>
        </div>
        
        <table class="table table-condensed">
            <thead>
                <th>Long Link</th>
                <th>Short Link</th>
                <th>Created</th>
                <th class="text-center">Clicks</th>
            </thead>
            
            <tbody>
            
            @foreach ( $urls as $url )
            
                <tr>
                    <td>{{ $url['long_url'] }}</td>
                    <td>{{ Config::get( 'app.url_no_protocol' ) }}/{{ $url['short_url'] }}</td>
                    <td>{{ $url['created_at'] }}</td>
                    <td class="text-center">{{ $url['hits'] }}</td>
                </tr>
            
            @endforeach
            
            </tbody>
        </table>
    </div>
    
    <p>&nbsp;<a class="btn btn-primary" href="/user/links" role="button">View All &raquo;</a></p>
</div>

@endif

@if ( ! Auth::check() )

<div class="container">
    <div class="jumbotron">
            <h1>Register for advanced features!</h1>
            
            <div class="row">
                <div class="col-md-4">
                    <h2>Save your links</h2>
                    <p>
                        Come back at any time to see the links you have shortened previously, and the
                        corresponding shorter links.
                    </p>
                </div>
                
                <div class="col-md-4">
                    <h2>Track all clicks</h2>
                    <p>
                        See on which web sites your links have been clicked, and how many times they have
                        been clicked.
                    </p>
                </div>
                
                <div class="col-md-4">
                    <div class="jumbotron" style="background: #5cb85c;">
                        <h1 class="text-center" style="color: white">$10</h2>
                        <h3 class="text-center" style="color: white">per month</h3>
                    </div>
                </div>
            </div>
            
            <p><a class="btn btn-primary btn-lg" href="/user/add" role="button">Register Now &raquo;</a></p>
    </div>
</div>

@endif
	
@stop