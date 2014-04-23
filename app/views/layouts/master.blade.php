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
        <link 
            rel="stylesheet" 
            href="{{ URL::asset( 'static/css/sticky-footer.css' ) }}"
        >
        
        @yield( 'styles' )
	
		<title>bernly.com | Link Shorterner</title>
	</head>
	
	<body>
		<div class="navbar navbar-default" role="navigation">
			<div class="container" >
				<div class="navbar-header">
					<button class="navbar-toggle" 
                        type="button"
                        data-toggle="collapse" 
                        data-target=".navbar-collapse"
                    >
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					
                    <a class="navbar-brand" href="/">
                        <img 
                            src="{{ URL::asset( 'static/img/bernly-logo.png') }}" 
                            width="41.11" 
                            height="20" 
                        >
                    </a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li><a href="/">Home</a></li>
						<li><a href="#about">About</a></li>
						<li><a href="#contact">Contact</a></li>
					</ul>
				
				@if ( Auth::check() )
				
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                My Account<b class="caret"></b>
                            </a>
                            
                            <ul class="dropdown-menu">
                                <li><a href="/user/view">Profile</a></li>
                                <li class="divider"></li>
                                <li><a href="/log/out">Log out</a></li>
                            </ul>
                        </li>
                    </ul>
                    
				@else
				
					<ul class="nav navbar-nav navbar-right">
						<li><a href="/log/in">Login</a></li>
						<li><a href="/user/add">Register</a></li>
					</ul>
					
				@endif
				
				</div><!--/.nav-collapse -->
			</div>
		</div>

		@yield( 'content' )
		
        <div id="footer">
            <div class="container">
                <p class="text-muted">&copy; Bernadine Computing (Pty) Ltd. 2014</p>
            </div>
        </div>

		<script src="{{ URL::asset( 'static/bower_components/jquery/jquery.min.js' ) }}"></script>
		<script src="{{ URL::asset( 'static/bower_components/bootstrap/dist/js/bootstrap.min.js' ) }}"></script>
		
		@yield( 'scripts' )
		
	</body>
</html>