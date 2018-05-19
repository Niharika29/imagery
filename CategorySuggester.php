<?php

require_once 'vendor/autoload.php';

/**
 * Class for suggesting categories
 */
class CategorySuggester {

	/**
	 * Array for features we found after doing processing
	 */
	public $features;

	/**
	 * Constructor
	 * @param $features Array Features for the image
	 */
	function __construct ( $features ) {
		$this->features = $features;
	}

	/**
	 * Blindly find categories for features we got back after processing image
	 * @param $features Array of features the image has
	 * @return Array of categories that could be used
	 */
	public function getCategories() {
		$probableCategories = [];
		foreach ( $this->features as $feature => $value ) {
			if ( $feature == 'countFace' ) {
				$probableCategories[] = 'Category:People';
			} else if ( $feature == 'percentFace' ) {
				if ( $value > 60 ) {
					$probableCategories[] = 'Category:Selfies';
				}
			} else if ( $value == 'expression' ) {
				switch ( $feature ) {
					case 'joyLikelihood':
						$probableCategories[] = 'Category:Happiness';
						break;
					case 'sorrowLikelihood':
						$probableCategories[] = 'Category:Sadness';
						break;
					case 'angerLikelihood':
						$probableCategories[] = 'Category:Anger';
						break;
					case 'surpriseLikelihood':
						$probableCategories[] = 'Category:Surprise';
						break;
					case 'blurredLikelihood':
						$probableCategories[] = 'Category:Blurred images';
						break;
					case 'headwearLikelihood':
						$probableCategories[] = 'Category:Headgear';
						break;
					default:
						break;
				}
			} else {
				$probableCategories[] = 'Category:' . $feature;
			}
		}

		// If we don't get any probable categories, return
		if ( count( $probableCategories ) <= 0 ) {
			return false;
		}

		// Make API call to commons categoryinfo API
		$client = new GuzzleHttp\Client();
		$response = $client->request(
			'GET',
			'https://commons.wikimedia.org/w/api.php?',
			[ 'query' => [
				'action' => 'query',
				'prop' => 'categoryinfo',
				'titles' => implode( '|', $probableCategories ),
				'formatversion' => 2,
				'format' => 'json'
				]
			]
		);
		// Decode the response
		$result = json_decode( $response->getBody(), true );
		// Categories found
		$actualCategories = [];
		// Find the valid categories
		foreach ( $result['query']['pages'] as $element ) {
			if ( !array_key_exists( 'missing', $element ) && $element['categoryinfo']['hidden'] != true ) {
				$actualCategories[] = $element['title'];
			}
		}
		// If we found any likely categories, return those else false
		if ( count( $actualCategories ) > 0 ) {
			return $actualCategories;
		}
		return false;
	}

}
