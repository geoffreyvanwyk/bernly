<?php
	require_once 'configuration.php';
	
	try {
		$db = new PDO('mysql:host='.DB_HOST_NAME.';dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
	} catch (PDOException $e) {
		echo $e->getMessage() . '<br>';
		
	} catch (Exception $e) {
		echo $e->getMessage() . '<br>';
	}