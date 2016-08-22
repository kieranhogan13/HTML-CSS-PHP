<?php
/**
 * @version 1.0.
 * @author Kieran Hogan kieran.hogan3@student.dit.ie
 */

/**
 * Controller for the all responses, promotes DRY
 */

class Controller {
	private $slimApp;
	private $model;
	private $requestBody;
	public function __construct($model, $slimApp) {
		
		$this->model = $model;
		$this->slimApp = $slimApp;
	}
	
	/**
	 * Function for performing generic get response for multiple
	 * 
	 * @param answers fed from controllers
	 */
	public function getResponses($answers) {
		if ($answers != null) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$this->model->apiResponse = $answers;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE 
			);
			$this->model->apiResponse = $Message;
		}
	}
	
	/**
	 * Function for performing generic get response
	 * 
	 * @param answer fed from controllers
	 */
	public function getResponse($answer) {
		if ($answer != null) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$this->model->apiResponse = $answer;
		} else {
			
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE 
			);
			$this->model->apiResponse = $Message;
		}
	}
	
	/**
	 * Function for performing generic createNew response
	 * 
	 * @param newId fed from controllers
	 */
	public function createNewResponse($newId) {
		if ($newId != null) {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_CREATED );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_CREATED,
					"id: " => "$newId" 
			);
			$this->model->apiResponse = $Message;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_INVALIDBODY 
			);
			$this->model->apiResponse = $Message;
		}
	}
	
	/**
	 * Function for performing generic update response
	 * 
	 * @param id fed from controllers
	 */
	public function updateResponse($id) {		
		if ($id){
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_UPDATED,
					"Rows updated: " => "$id"
			);
			$this->model->apiResponse = $Message;
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_NOTMODIFIED_MESSAGE
			);
			$this->model->apiResponse = $Message;
		}
	}
	
	/**
	 * Function for performing generic delete response
	 * 
	 * @param answer fed from controllers
	 */
	public function deleteResponse($id) {
		if ($id != null)
		{
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_DELETED,
					"id" => "$id"
			);
			$this->model->apiResponse = $Message;
		}
		else
		{
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_NOTMODIFIED_MESSAGE
			);
			$this->model->apiResponse = $Message;
		}
	}
	
	/**
	 * Function for performing generic search response
	 * 
	 * @param answer fed from controllers
	 */
	public function searchResponse($answer) {
		if ($answer != null) 
		{
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
			$this->model->apiResponse = $answer;
		} 
		else 
		{	
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE
			);
			$this->model->apiResponse = $Message;
		}
	}
}


?>