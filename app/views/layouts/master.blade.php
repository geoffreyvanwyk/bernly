<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
		<meta name="application" content="bernly">
		<meta name="author" content="Bernadine Computing">
		<meta name="description" content="A link (URL, web address) shortener.">
		<meta name="keywords" content="link, URL, web address, address, shorter, shorten, link shortener">

		<link rel="stylesheet" href="static/bower_components/bootstrap/dist/css/bootstrap.min.css"	>
	
		<title>Link Shorterner | bernly.com</title>
	</head>
	
	<body>
		<div class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0px">
			<div class="container" >
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="#">Home</a></li>
						<li><a href="#about">About</a></li>
						<li><a href="#contact">Contact</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#">Login</a></li>
						<li class="active"><a href="./">Register</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>

		@yield('content')
		
	    <div class="jumbotron">
			<div class="container">
				<h1>Register for more features!</h1>
				
				<div class="row">
					<div class="col-md-4">
						<h2>Save your links</h2>
						<p>Come back at any time to see the links you have shortened before, and the corresponding shorter links.</p>
					</div>
					
					<div class="col-md-4">
						<h2>Tracking</h2>
						<p>See on which web sites your links have been clicked, and how many times they have been clicked.</p>
					</div>
					
					<div class="col-md-4">
						<h2>$10</h2>
						<p>per month</p>
					</div>
				</div>
				
				<p><a class="btn btn-primary btn-lg" role="button">Register Now &raquo;</a></p>
				
			</div>
		</div>
		
		<div class="container">
			<footer>
				<p>&copy; Bernadine Computing (Pty) Ltd. 2014</p>
			</footer>
		</div>
		
		<script src="static/bower_components/jquery/jquery.min.js"></script>
		<script src="static/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	</body>
</html>