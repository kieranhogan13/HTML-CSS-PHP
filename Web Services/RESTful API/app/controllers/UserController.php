<?php

/**
 * @version 1.0.
 * @author Kieran Hogan kieran.hogan3@student.dit.ie
 */

/**
 * Controller for the users
 */
class UserController {
	private $slimApp;
	private $model;
	private $requestBody;
	private $controller;
	
	/**
	 * Function for constructing model and controller and assignming actions to methods
	 *
	 */
	public function __construct($model, $action = null, $slimApp, $parameteres = null) {
		include_once 'controllers/Controller.php';
		$this->model = $model;
		$this->slimApp = $slimApp;
		$this->controller = new Controller($model, $slimApp);
		$this->requestBody = json_decode ( $this->slimApp->request->getBody (), true ); // this must contain the representation of the new user
		
		if (! empty ( $parameteres ["id"] ))
			$id = $parameteres ["id"];
		
		switch ($action) {
			case ACTION_GET_USER :
				$this->getUser ( $id );
				break;
			case ACTION_GET_USERS :
				$this->getUsers ();
				break;
			case ACTION_UPDATE_USER :
				$this->updateUser ( $id, $this->requestBody );
				break;
			case ACTION_CREATE_USER :
				$this->createNewUser ( $this->requestBody );
				break;
			case ACTION_DELETE_USER :
				$this->deleteUser ( $id );
				break;
			case ACTION_SEARCH_USERS :
				$string = $parameteres ["SearchingString"];
				$this->searchUsers ( $string );
				break;
			case ACTION_AUTH_USER :
				$password = $parameteres ["password"];
				$this->authUser ( $id, $password );
				break;
			case null :
				$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
				$Message = array (
						GENERAL_MESSAGE_LABEL => GENERAL_CLIENT_ERROR 
				);
				$this->model->apiResponse = $Message;
				break;
		}
	}
	
	/**
	 * Function for authenticating by userid and password
	 */
	private function authUser($userId, $password) {
		$answer = $this->model->getUser ( $userId );
		if (!empty($answer))
		{
			if ($answer[0]["password"] == $password)
			{
				$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
				$this->model->apiResponse = true;
				return true;
			}
		}
		$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
		$this->model->apiResponse = false;
	}
	
	/**
	 * Function for calling getUsers method on model and getResponse on controller
	 */
	private function getUsers() {
		$answers = $this->model->getUsers();
		$this->controller->getResponses($answers);
	}
	
	/**
	 * Function for calling getUser method on model and getResponse on controller
	 */
	private function getUser($userId) {
		$answer = $this->model->getUser($userId);
		$this->controller->getResponse($answer);
	}
	
	/**
	 * Function for calling createNewUser method on model and createNewResponse on controller
	 */
	private function createNewUser($newUser) {
		$newId = $this->model->createNewUser($newUser);
		$this->controller->createNewResponse($newId);
	}
	
	/**
	 * Function for calling updateUser method on model and updateResponse on controller
	 */
	private function updateUser($userId, $userNewRepresentation) {
		$userId = $this->model->updateUsers($userId, $userNewRepresentation);
		$this->controller->updateResponse($userId, $userNewRepresentation);
	}
	
	/**
	 * Function for calling deleteUser method on model and deleteResponse on controller
	 */
	private function deleteUser($userId) {
		$userId = $this->model->deleteUser($userId);
		$this->controller->deleteResponse($userId);
	}
	
	/**
	 * Function for calling searchUsers method on model and searchResponse on controller
	 */
	private function searchUsers($string) {
		$answer = $this->model->searchUsers($string);
		$this->controller->searchResponse($answer);
	}
}


?>