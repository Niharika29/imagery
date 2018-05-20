<?php

require_once dirname(__FILE__) . '/../config.php';
require_once '../vendor/autoload.php';

header( 'Access-Control-Allow-Origin: *' );

// Get the image from the API call
$image = $_GET['image'] ?: 'test';
$jsonp_callback = isset( $_GET['callback'] ) ? $_GET['callback'] : null;

// Create a new Imagery instance and give it the image
$imagery = new Imagery( $apiKey );
$data = json_encode( $imagery->main( $image ) );

print $jsonp_callback ? '$jsonp_callback(' . $data . ')' : $data;
