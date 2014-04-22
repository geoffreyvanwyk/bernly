<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
		<meta name="application" content="bernly">
		<meta name="author" content="Bernadine Computing">
		<meta name="description" content="A link (URL, web address) shortener.">
		<meta name="keywords" content="link, URL, web address, address, shorter, shorten, link shortener">

		<link 
			rel="stylesheet" 
			href="{{ URL::asset( 'static/bower_components/bootstrap/dist/css/bootstrap.min.css' ) }}"
		>
	
		<title>Link Shorterner | bernly.com</title>
	</head>
	
	<body>
		<div class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0px">
			<div class="container" >
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" 
                        data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li><a href="/">Home</a></li>
						<li><a href="#about">About</a></li>
						<li><a href="#contact">Contact</a></li>
					</ul>
				
				@if ( Auth::check() )
				
                    <ul class="nav navbar-nav navbar-right">
                        <p class="navbar-text">Logged-in as {{{ Auth::user()->email }}}</p>
                        <li><button onclick="window.location = '/user/logout'" class="btn btn-default navbar-btn">Logout</button></li>
                    </ul>
                    
				@else
				
					<ul class="nav navbar-nav navbar-right">
						<li><a href="/user/login">Login</a></li>
						<li><a href="/user/register">Register</a></li>
					</ul>
					
				@endif
				
				</div><!--/.nav-collapse -->
			</div>
		</div>

		@yield( 'content' )
		
		<div class="container">
			<footer>
				<p>&copy; Bernadine Computing (Pty) Ltd. 2014</p>
			</footer>
		</div>
		
		<script src="{{ URL::asset( 'static/bower_components/jquery/jquery.min.js' ) }}"></script>
		<script src="{{ URL::asset( 'static/bower_components/bootstrap/dist/js/bootstrap.min.js' ) }}"></script>
	</body>
</html>