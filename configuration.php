<?php
	$config_json_string = file_get_contents("configuration.json");
	$config_array = json_decode($config_json_string, true);
	
	define('DB_HOST_NAME', $config_array['database']['host']);
	define('DB_NAME', $config_array['database']['name']);
	define('DB_USERNAME', $config_array['database']['username']);
	define('DB_PASSWORD', $config_array['database']['password']);
	
	define('APP_HOST_NAME', $config_array['app']['host']);
	define('APP_PATH', $config_array['app']['path']);