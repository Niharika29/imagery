<?php

require_once dirname(__FILE__) . '/../config.php';
require_once '../vendor/autoload.php';

// Get the image from the API call
$image = $_GET['image'] ?: 'test';

// Create a new Imagery instance and give it the image
$imagery = new Imagery( $apiKey );
$data = $imagery->main( $image );

echo json_encode( $data );
