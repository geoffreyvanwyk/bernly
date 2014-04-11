<?php

/* CREATE configuration.json FILE */
	
	echo "Enter configuration settings." . PHP_EOL;
	
	echo "Database host: ";
	$db_host = trim(fgets(STDIN));
	
	echo "Database name: ";
	$db_name = trim(fgets(STDIN));
	
	echo "Database username: ";
	$db_username = trim(fgets(STDIN));
	
	echo "Database password: ";
	$db_password = trim(fgets(STDIN));
	
	echo "Application domain name: ";
	$app_host = trim(fgets(STDIN));
	
	echo "Application path: ";
	$app_path = trim(fgets(STDIN));
	
	$configuration_string = <<<HEREDOC
{ 
	"database": {
		"host": "$db_host",
		"name": "$db_name", 
		"username": "$db_username",
		"password": "$db_password"
	},
	"app": {
		"host": "$app_host",
		"path": "$app_path"
	}
}
HEREDOC;
	
	try {
		file_put_contents("configuration.json", $configuration_string);
		
	} catch (Exception $e) {
		echo $e->getMessage();
	}

/* EDIT .htaccess FILE */
	
	$htaccess_string = <<<HEREDOC
ErrorDocument 404 {$app_path}index.php
HEREDOC;
	
	try {
		file_put_contents(".htaccess", $htaccess_string);
		
	} catch (Exception $e) {
		echo $e->getMessage();
	}