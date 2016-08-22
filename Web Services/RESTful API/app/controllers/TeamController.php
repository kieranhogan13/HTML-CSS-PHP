<?php

/**
 * @version 1.0.
 * @author Kieran Hogan kieran.hogan3@student.dit.ie
 */

/**
 * Controller for the teams
 */
class TeamController {
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
		$this->requestBody = json_decode ( $this->slimApp->request->getBody (), true ); // this must contain the representation of the new team
		
		if (! empty ( $parameteres ["id"] ))
			$id = $parameteres ["id"];
		
		switch ($action) {
			case ACTION_GET_TEAM :
				$this->getTeam ( $id );
				break;
			case ACTION_GET_TEAMS :
				$this->getTeams ();
				break;
			case ACTION_UPDATE_TEAM :
				$this->updateTeam ( $id, $this->requestBody );
				break;
			case ACTION_CREATE_TEAM :
				$this->createNewTeam ( $this->requestBody );
				break;
			case ACTION_DELETE_TEAM :
				$this->deleteTeam ( $id );
				break;
			case ACTION_SEARCH_TEAMS :
				$string = $parameteres ["SearchingString"];
				$this->searchTeams ( $string );
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
	 * Function for calling getTeams method on model and getResponse on controller
	 */
	private function getTeams() {
		$answers = $this->model->getTeams ();
		$this->controller->getResponses($answers);
	}
	
	/**
	 * Function for calling getTeam method on model and getResponse on controller
	 */
	private function getTeam($teamId) {
		$answer = $this->model->getTeam ( $teamId );
		$this->controller->getResponse($answer);
	}
	
	/**
	 * Function for calling createNewTeam method on model and createNewResponse on controller
	 */
	private function createNewTeam($newTeam) {
		$newId = $this->model->createNewTeam ($newTeam);
		$this->controller->createNewResponse($newId);
	}
	
	/**
	 * Function for calling updateTeam method on model and updateResponse on controller
	 */
	private function updateTeam($teamId, $teamNewRepresentation) {
		$numOfRows = $this->model->updateTeams($teamId, $teamNewRepresentation);
		$this->controller->updateResponse($numOfRows);
	}

	/**
	 * Function for calling deleteTeam method on model and deleteResponse on controller
	 */
	private function deleteTeam($teamId) {
		$teamId = $this->model->deleteTeam($teamId);
		$this->controller->deleteResponse($teamId);
	}
	
	/**
	 * Function for calling searchTeams method on model and searchResponse on controller
	 */
	private function searchTeams($string) {
		$answer = $this->model->searchTeams($string);
		$this->controller->searchResponse($answer);
	}
	
}


?>