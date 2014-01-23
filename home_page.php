<!DOCTYPE html>
<html>
	<head>
		<title>URL Shorterner | bernly.com</title>
		<link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>
		<div class="container">

		<?php if (isset($short_url)): ?>
			<p><strong>Short URL </strong><?php echo $short_url; ?></p>
		<?php endif; ?>

			<form action="." method="get">
				<div class="form-group">
					<input type="url" name="long_url" placeholder="Long URL" class="form-control">
				</div>
				<button type="submit" name="submit" class="btn btn-success form-control">Shorten</button>
			</form>
		</div>
	</body>
</html>