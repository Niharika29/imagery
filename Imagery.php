<?php

require_once 'vendor/autoload.php';
use Wikisource\GoogleCloudVisionPHP\GoogleCloudVision;

class Imagery {

	/**
	 * GoogleCloudVision client
	 * Docs at https://cloud.google.com/vision/docs/reference/rest/v1/images/annotate
	*/
	protected $gcv;

	/*
	 * Constructor which sets the apiKey variable
	 *
	 */
	public function __construct( $apiKey ) {
		$this->gcv = new GoogleCloudVision();
		$this->gcv->setKey( $apiKey );
	}

	/**
	 * Main driver function
	 * @param $image String URL for the image being processed
	 */
	public function main( $image ) {
		$valid = $this->validateRequest( $image );
		// If valid, send it off to Google API
		if ( $valid ) {
			$this->gcv->setImageMaxSize( 1024*1024*20 );
			$this->gcv->setImage( $image );
			$this->gcv->addFeatureFaceDetection( 5 );
			$this->gcv->addFeatureLandmarkDetection( 5 );
			$this->gcv->addFeatureLogoDetection( 5 );
			$this->gcv->addFeatureLabelDetection( 5 );
			$this->gcv->addFeatureTextDetection( 5 );
			$this->gcv->setImageContext( [ 'webDetectionParams' => [ 'includeGeoResults' => true ] ] );

			$response = $this->gcv->request();
			$result = []; // Array that holds the result
			$analyse = new AnalyseImage( $response, $image );
			$features = $analyse->processResponse();
			$result['features'] = $features;

			// Process result to get array of valid categories among elements
			if ( count( $features ) > 0 ) {
				$categorySuggester = new CategorySuggester( $features );
				$categories = $categorySuggester->getCategories();
				$result['categories'] = $categories;
			} else {
				echo 'nolabels';
			}
		}
		return $result;
	}

	/**
	 * Validating that the request is indeed from commons
	 * @param $url String URL for the image up for processing
	 */
	public function validateRequest( $url ) {
		// Make sure it's from commons
		if ( strpos( $url, 'upload.wikimedia.org' ) > 0 ) {
			return true;
		}
		return false;
	}

}
