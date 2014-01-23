<!DOCTYPE html>
<html>
	<head>
		<title>URL Shorterner | bernly.com</title>
		<link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="bower_components/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet">
		<style>
			body {
				padding-top: 50px; /* 40px to make the container go all the way to the bottom of the topbar */
			}
		</style>
	</head>
	<body>
		<div class="container">
			<img src="./bernly-logo.png" width="200" height="100">
			<br><br><br><br>
			<form action="." method="get">
				<div class="input-group">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-link"></span>
					</span>
					<input type="url" name="long_url" placeholder="Paste long URL here" class="form-control">
					<span class="input-group-btn">
						<button type="submit" name="submit" class="btn btn-success">Shorten</button>
					</span>
				</div>
			</form>

		<?php if (isset($short_url)): ?>
			<p><strong>Short URL </strong><?php echo $short_url; ?></p>
		<?php endif; ?>

		</div>
	</body>
</html>