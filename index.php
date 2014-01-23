<?php
	if (!empty($_GET['long_url'])) {
		try {
			$db = new PDO('mysql:host=localhost;dbname=bernly', 'root', 'T02qYxtGgFMo2OOtkjEp');
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			foreach ($db->query('SELECT id FROM URLs') as $row) {
				$new_id = $row['id'] + 1;
			}
			if (empty($new_id)) {
				$new_id = 1;
			}
			$short_url = base_convert($new_id, 10, 36);
			$db->exec("INSERT INTO URLs(short_url, long_url) VALUES('$short_url', '$_GET[long_url]')");
		} catch (PDOException $e) {
			echo $e->getMessage() . '<br>';
		} catch (Exception $e) {
			echo $e->getMessage() . '<br>';
		}
	}
?>

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