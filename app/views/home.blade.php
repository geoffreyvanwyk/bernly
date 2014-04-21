@extends('layouts.master')

@section('content')
	@if ( isset( $short_url ) )
		<div class="container">
			<div class="page-header">
				<h3>Result
					<span class="pull-right">
						<strong>
							{{ Config::get('app.url_no_protocol') }}/{{ $short_url }}
						</strong>
					</span>
				</h3>
			</div>
		</div>
	@endif
@stop