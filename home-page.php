<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="application" content="bernly">
		<meta name="author" content="Bernadine Computing">
		<meta name="description" content="A link (URL, web address) shortener.">
		<meta name="keywords" content="link, URL, web address, address, shorter, shorten, link shortener">

		<link href="static/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	
		<title>Link Shorterner | bernly.com</title>
	</head>
	<body>
		<div class="jumbotron">
			<div class="container">
				<div class="page-header">
					<a href="<?=APP_PATH?>">
						<img src="static/img/bernly-logo.png" width="200" height="100" class="center-block">
					</a>
					<p class="lead text-center">Cut your links down to size.</p>
				</div>
				<form action="." method="get">
					<div class="input-group" style="font-size: 14px !important">
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-link"></span>
						</span>
						<input type="url" name="long_url" placeholder="Paste long link here"
							class="form-control input-lg">
						<span class="input-group-btn">
							<button type="submit" name="submit" class="btn btn-success btn-lg">Shorten</button>
						</span>
					</div>
				</form>
			</div>
		</div>

		<div class="container">
		</div>

	<?php if (isset($short_url)): ?>
		<div class="container">
			<div class="page-header">
				<h3>Result<span class="pull-right"><strong><?=$short_url?></strong></span></h3>
			</div>
		</div>
	<?php endif; ?>
	</body>
</html>