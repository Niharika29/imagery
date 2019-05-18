<?php

require_once 'vendor/autoload.php';

/**
 * Class to suggest tags for Depict statements on Commons
 */
class SuggestTags {
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
	 * Find potential Wikidata tags for features we got back after processing the image
	 * @param $features Array of features the image has
	 * @return Array of tags that could be used
	 * https://en.wikipedia.org/w/api.php?action=query&prop=pageprops&ppprop=wikibase_item&titles=visual%20arts&formatversion=2
	 */
	public function getItems() {
		$finalItems = [];

		foreach ( $this->features as $feature => $value ) {
			// Make API call to get actual items to map to our features
			$client = new GuzzleHttp\Client();
			$response = $client->request(
				'GET',
				'https://wikidata.org/w/api.php?',
				[ 'query' => [
					'action' => 'wbsearchentities',
					'search' => $feature,
					'formatversion' => 2,
					'language' => 'en',
					'format' => 'json'
					]
				]
			);
			// Decode the response
			$result = json_decode( $response->getBody(), true );
			// Find the valid categories
			if ( $result['search'][0] ) {
				$finalItems[$result['search'][0]['label']] = [ $result['search'][0]['title'], $result['search'][0]['description'] ];
			}
		}

		return $finalItems;
	}
}
