<?php
/**
 * @version 1.0.
 * @author Kieran Hogan kieran.hogan3@student.dit.ie
 */

/**
 * Controller for the players
 */
 
class PlayerController {
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
		$this->requestBody = json_decode ( $this->slimApp->request->getBody (), true ); // this must contain the representation of the new player
		
		if (! empty ( $parameteres ["id"] ))
			$id = $parameteres ["id"];
		
		switch ($action) {
			case ACTION_GET_PLAYER :
				$this->getPlayer ( $id );
				break;
			case ACTION_GET_PLAYERS :
				$this->getPlayers ();
				break;
			case ACTION_UPDATE_PLAYER :
				$this->updatePlayer ( $id, $this->requestBody );
				break;
			case ACTION_CREATE_PLAYER :
				$this->createNewPlayer ( $this->requestBody );
				break;
			case ACTION_DELETE_PLAYER :
				$this->deletePlayer ( $id );
				break;
			case ACTION_SEARCH_PLAYERS :
				$string = $parameteres ["SearchingString"];
				$this->searchPlayers ( $string );
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
	 * Function for calling getPlayers method on model and getResponse on controller
	 */
	private function getPlayers() {
		$answers = $this->model->getPlayers();
		$this->controller->getResponses($answers);
	}
	
	/**
	 * Function for calling getPlayer method on model and getResponse on controller
	 */
	private function getPlayer($playerId) {
		$answer = $this->model->getPlayer($playerId);
		$this->controller->getResponse($answer);
	}
	
	/**
	 * Function for calling createNewPlayer method on model and createNewResponse on controller
	 */
	private function createNewPlayer($newPlayer) {
		$newId = $this->model->createNewPlayer($newPlayer);
		$this->controller->createNewResponse($newId);
	}
	
	/**
	 * Function for calling updatePlayer method on model and updateResponse on controller
	 */
	private function updatePlayer($playerId, $playerNewRepresentation) {
		$numOfRows = $this->model->updatePlayers($playerId, $playerNewRepresentation);
		$this->controller->updateResponse($numOfRows);
	}
	
	/**
	 * Function for calling deletePlayer method on model and deleteResponse on controller
	 */
	private function deletePlayer($playerId) {
		$playerId = $this->model->deletePlayer($playerId);
		$this->controller->deleteResponse($playerId);
	}
	
	/**
	 * Function for calling searchPlayers method on model and searchResponse on controller
	 */
	private function searchPlayers($string) {
		$answer = $this->model->searchPlayers($string);
		$this->controller->searchResponse($answer);
	}
	
}


?>