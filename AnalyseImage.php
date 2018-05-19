<?php

require_once 'vendor/autoload.php';

/**
 * Class for analysing the image responses and picking features
 */
class AnalyseImage {

	/* Multi-dimensional response array from the API */
	public $response;

	/* Url for the image */
	public $image;

	/**
	 * Constructor
	 * @param $response Array response from the API
	 * @param $image String Url for the image
	 */
	function __construct( $response, $image ) {
		$this->response = $response;
		$this->image = $image;
	}

	/**
	 * Process the response we get from the API
	 * @param $response Response from the Cloud vision API
	 * @param $image URL to the image we are processing
	 */
	public function processResponse() {
		$features = [];
		// Go over all the annotations we got back
		foreach ( $this->response['responses']['0'] as $key => $value ) {
			if ( $key == 'landmarkAnnotations' ) {
				// Landmarks/monuments in the image
				foreach ( $value as $title => $info ) {
					$features[ $info['description'] ] = round ( $info['score'] * 100, 2 );
				}
			} else if ( $key == 'faceAnnotations' ) {
				// Faces in the image
				$features['countFace'] = count( $value ); // # of faces
				if ( count( $value ) > 0 ) {
					// Percentage area of the image covered by a face
					$percent = $this->getFacialPercentage( $value );
					$features['percentFace'] = $percent;
					// Expressions we got from the photo
					$expressions = $this->getFacialFeatures( $value );
					foreach ( $expressions as $expression ) {
						$features[$expression] = 'expression';
					}
				}
			} else if ( $key == 'labelAnnotations' ) {
				// Labels for objects in the image
				foreach ( $value as $title => $info ) {
					$features[ $info['description'] ] = round( $info['score'] * 100, 2 );
				}
			}
		}
		return $features;
	}

	/**
	 * Recognizing facial features and other things like headgear
	 * @param $faceAnnotations Array of facial annotations we got from the API
	 * @return Array of features we got
	 */
	public function getFacialFeatures( $faceAnnotations ) {
		$featuresFound = [];
		foreach ( $faceAnnotations as $faceNumber => $faceFeatures ) {
			foreach ( $faceFeatures as $property => $likelihood ) {
				if ( $likelihood == 'VERY_LIKELY' ||
					$likelihood == 'LIKELY' ||
					$likelihood == 'POSSIBLE') {
					$featuresFound[] = $property;
				}
			}
		}
		return array_unique( $featuresFound );
	}
	/**
	 * This function is for doing the math to find out percent area of an image covered by face(s)
	 * @param $faceAnnotations Array for facial annotations we got from the API
	 * @return Float percentage value of area covered by face(s) in the image
	 */
	public function getFacialPercentage( $faceAnnotations ) {
		// var_dump( $faceAnnotations );
		$faceSizeTotal = 0;
		foreach ( $faceAnnotations as $faceNumber => $faceFeatures ) {
			$xMax = 0;
			$yMax = 0;
			$xMin = 10000000000000;
			$yMin = 10000000000000;
			foreach ( $faceFeatures['boundingPoly']['vertices'] as $key2 => $value2 ) {
				// Find maximum and minumum of the x coordinates
				if ( isset( $value2['x'] ) && $value2['x'] > $xMax ) {
					$xMax = $value2['x'];
				} else if ( isset( $value2['x'] ) && $value2['x'] < $xMin ) {
					$xMin = $value2['x'];
				} else if ( !isset( $value2['x'] ) ) {
					$xMin = 0;
				}
				// Find maximum and minumum of the y coordinates
				if ( isset( $value2['y'] ) && $value2['y'] > $yMax ) {
					$yMax = $value2['y'];
				} else if ( isset( $value2['y'] ) && $value2['y'] < $yMin ) {
					$yMin = $value2['y'];
				} else if ( !isset( $value2['y'] ) ) {
					$yMin = 0;
				}
			}
			// echo 'xmax ' . $xMax . ' xmin ' . $xMin . ' ymax ' . $yMax . ' ymin ' . $yMin;
			$faceSizeTotal = $faceSizeTotal + ( ( $xMax - $xMin ) * ( $yMax - $yMin ) );
		}

		$imgDimensions = getimagesize( $this->image );
		$fileSize = $imgDimensions[0] * $imgDimensions[1];
		return round( ( $faceSizeTotal * 100 ) / $fileSize, 2 );
	}

}
