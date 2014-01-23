<?php
	require_once 'database_connection.php';
	require_once 'configuration.php';

	$url_parts = explode('/', $_SERVER['REQUEST_URI']);
	if (!empty($url_parts[3]) && $url_parts[3][0] !== '?') {
		try {
			foreach ($db->query("SELECT long_url FROM URLs WHERE short_url = " . $db->quote($url_parts[3][0])) as $row) {
				$long_url = $row['long_url'];
			}
			http_redirect($long_url);
		} catch (PDOException $e) {
			echo $e->getMessage() . '<br>';
		} catch (Exception $e) {
			echo $e->getMessage() . '<br>';
		}
	} else if (!empty($_GET['long_url'])) {
		try {
			foreach ($db->query('SELECT id FROM URLs') as $row) {
				$new_id = $row['id'] + 1;
			}
			if (empty($new_id)) {
				$new_id = 1;
			}
			$short_url_path = base_convert($new_id, 10, 36);
			$short_url = APP_HOST_NAME . '/' . $short_url_path;
			$db->exec("INSERT INTO URLs(short_url, long_url) VALUES('$short_url_path', '$_GET[long_url]')");
		} catch (PDOException $e) {
			echo $e->getMessage() . '<br>';
		} catch (Exception $e) {
			echo $e->getMessage() . '<br>';
		}
	}

	require_once "home_page.php";
