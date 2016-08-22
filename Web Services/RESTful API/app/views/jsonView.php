<?php
/**
 * @version 1.0.
 * @author Kieran Hogan kieran.hogan3@student.dit.ie
 */

/**
 * View for the MVC of web service
 */

class jsonView
{
	private $model, $controller, $slimApp;

	/**
	 * Constructor
	 *
	 * @param $controller constructor 
	 * @param $model constructor
	 * @param $slimApp constructor
	 */
	
	public function __construct($controller, $model, $slimApp) {
		$this->controller = $controller;
		$this->model = $model;
		$this->slimApp = $slimApp;		
	}
	
	
	/**
	 * Outputs data to JSON
	 */
	
	public function outputJSON(){
		//prepare json response
		header('Content-Type: application/json; charset=utf-8');
		$jsonResponse = json_encode($this->model->apiResponse);
		$this->slimApp->response->write($jsonResponse);
	}
	
	/**
	 * @version 1.0.
	 * @author Ben Creasey ben.creasey@student.dit.ie
	 */
	
	/**
	 * Outputs data to XML
	 */
 	public function outputXML(){
 		//prepare XML response
 		header('Content-Type: application/xml');
		
		function array2xml($array) {
			$xml = '';
			  foreach ($array as $key => $value) {
			  	if (is_array($value)) {
				  $xml .= '<' . $key . '>' . array2xml($value) . '</' . $key . '>';
				}
				else {
				  $xml .= '<' . $key . '>' . $value . '</' . $key . '>';
				}
			  }
			return $xml;
		}
		
 		$XMLResponse = array2xml($this->model->apiResponse);
		$this->slimApp->response->write($XMLResponse);
 	}
	
}
?>

