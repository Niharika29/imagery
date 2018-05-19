<?php

require_once 'vendor/autoload.php';
use Wikisource\GoogleCloudVisionPHP\GoogleCloudVision;

// $child->main( 'https://upload.wikimedia.org/wikipedia/commons/6/6b/Hans_Sachs._Monument.jpg' );
// $child->main( 'https://upload.wikimedia.org/wikipedia/commons/b/b6/Volleyball_match_between_national_teams_of_Iran_and_Italy_at_the_Olympic_Games_in_2016_-_15.jpg' );
// $child->main( 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/07/The_Shard_from_the_Sky_Garden_2015.jpg/298px-The_Shard_from_the_Sky_Garden_2015.jpg' );
// $child->main( 'https://upload.wikimedia.org/wikipedia/commons/3/37/Abdul_Wahab_in_Lake_Saif_ul_Malook.jpg' );
// $child->main( 'https://upload.wikimedia.org/wikipedia/commons/c/c0/BDavis_%28WMF%29_Selfie_%28red_shirt_edition%29.jpg' );
// $child->main( 'https://upload.wikimedia.org/wikipedia/commons/f/f8/Andrea_Rodriguez.JPG' );

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
