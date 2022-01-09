<?php
	include_once("WebShipAPI.php");
	$api = new WebShipAPI();
	$res = $api->getCustomer_GET();
	print_r($res);exit;
?>