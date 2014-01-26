<!DOCTYPE html>
<html>
	<head>
		<title>URL Shorterner | bernly.com</title>
		<link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="bower_components/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet">
		<style>
			body {
				padding-top: 0px; /* 40px to make the container go all the way to the bottom of the topbar */
			}
		</style>
	</head>
	<body>
		<div class="jumbotron">
			<div class="container">
				<div class="page-header">
					<a href="/">
						<img src="./bernly-logo.png" width="200" height="100" class="center-block">
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
		<br><br>
		<div class="jumbotron">
			<div class="container">
				<h3><?php echo $short_url; ?></h3>
			</div>
		</div>
	<?php endif; ?>
	</body>
</html>