<?php
/**
 * @version 1.0.
 * @author Kieran Hogan kieran.hogan3@student.dit.ie
 * @author Ben Creasey ben.creasey@student.dit.ie
 */

/**
 * Main file that connects MVC web service
 */

require_once "../Slim/Slim.php";
Slim\Slim::registerAutoloader ();

$app = new \Slim\Slim (); // slim run-time object

require_once "../app/conf/config.inc.php";


/**
 * Authenticates users for the web service
 *
 * @param route uses slim routing.
 *
 * @return bool returns true if authenticate, otherwise halts
 */

function authenticate(\Slim\Route $route)
{
	include_once "models/UserModel.php";
	include_once "controllers/UserController.php";
	$appInstance = \Slim\Slim::getInstance();
	$headers = $appInstance->request->headers;
	$id = $headers["id"];
	$password = $headers["password"];
	
	$authResponse = null;
	if ($headers["id"] != null && $headers["password"] != null)
	{
		$action = ACTION_AUTH_USER;
		$model = new UserModel(); // common model
		$controller = new UserController( $model, $action, $appInstance, $headers );
		$authResponse = json_encode($model->apiResponse);
		if ($authResponse == "true")
		{
			return true;
		}
		$appInstance->halt(401);
	}
	else
	{
		$appInstance->halt(401);
	}
}


/**
 * Map for routing users table requests
 *
 * @param userid slim used for requests
 *
 * @return loadRunMVCComponents generates MVC components for CRUD operations
 */

$app->map ( "/users(/:id)", "authenticate", function ($userID = null) use($app) {
	
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["id"] = $userID; // prepare parameters to be passed to the controller (example: ID)
	
	if (($userID == null) or is_numeric ( $userID )) {
		switch ($httpMethod) {
			case "GET" :
				if ($userID != null)
					$action = ACTION_GET_USER;
				else
					$action = ACTION_GET_USERS;
				break;
			case "POST" :
				$action = ACTION_CREATE_USER;
				break;
			case "PUT" :
				$action = ACTION_UPDATE_USER;
				break;
			case "DELETE" :
				$action = ACTION_DELETE_USER;
				break;
			default :
		}
	}
	return new loadRunMVCComponents ( "UserModel", "UserController", "jsonView", $action, $app, $parameters );
} )->via ( "GET", "POST", "PUT", "DELETE" );


/**
 * Map for routing users table search
 *
 * @param userid slim used for requests
 *
 * @return loadRunMVCComponents generates MVC components for GET
 */

$app->map ( "/users/search/:SearchingString", "authenticate", function ($searchString = null) use($app) {
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["SearchingString"] = $searchString;
	if (!$searchString == null) {
		switch ($httpMethod) {
			case "GET" :
				if ($searchString != null)
					$action = ACTION_SEARCH_USERS;
					break;
		}
	}
	return new loadRunMVCComponents ( "UserModel", "UserController", "jsonView", $action, $app, $parameters );
} )->via ( "GET" );


/**
 * Map for routing teams table requests
 *
 * @param teamid slim used for requests
 *
 * @return loadRunMVCComponents generates MVC components for CRUD operations
 */

$app->map ( "/teams(/:id)", "authenticate", function ($teamID = null) use($app) {

	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["id"] = $teamID; // prepare parameters to be passed to the controller (example: ID)

	if (($teamID == null) or is_numeric ( $teamID )) {
		switch ($httpMethod) {
			case "GET" :
				if ($teamID != null)
					$action = ACTION_GET_TEAM;
					else
						$action = ACTION_GET_TEAMS;
					break;
			case "POST" :
				$action = ACTION_CREATE_TEAM;
				break;
			case "PUT" :
				$action = ACTION_UPDATE_TEAM;
				break;
			case "DELETE" :
				$action = ACTION_DELETE_TEAM;
				break;
			default :
		}
	}
	return new loadRunMVCComponents ( "TeamModel", "TeamController", "jsonView", $action, $app, $parameters );
} )->via ( "GET", "POST", "PUT", "DELETE" );


/**
 * Map for routing teams table search
 *
 * @param teamid slim used for requests
 *
 * @return loadRunMVCComponents generates MVC components for GET
 */

$app->map ( "/teams/search/:SearchingString", "authenticate", function ($searchString = null) use($app) {
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["SearchingString"] = $searchString;
	if (!$searchString == null) {
		switch ($httpMethod) {
			case "GET" :
				if ($searchString != null)
					$action = ACTION_SEARCH_TEAMS;
					break;
		}
	}
	return new loadRunMVCComponents ( "TeamModel", "TeamController", "jsonView", $action, $app, $parameters );
} )->via ( "GET" );


/**
 * Map for routing players table requests
 *
 * @param playerid slim used for requests
 *
 * @return loadRunMVCComponents generates MVC components for CRUD operations
 */

$app->map ( "/players(/:id)", "authenticate", function ($playerID = null) use($app) {

	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["id"] = $playerID; // prepare parameters to be passed to the controller (example: ID)

	if (($playerID == null) or is_numeric ( $playerID )) {
		switch ($httpMethod) {
			case "GET" :
				if ($playerID != null)
					$action = ACTION_GET_PLAYER;
					else
						$action = ACTION_GET_PLAYERS;
					break;
			case "POST" :
				$action = ACTION_CREATE_PLAYER;
				break;
			case "PUT" :
				$action = ACTION_UPDATE_PLAYER;
				break;
			case "DELETE" :
				$action = ACTION_DELETE_PLAYER;
				break;
			default :
		}
	}
	return new loadRunMVCComponents ( "PlayerModel", "PlayerController", "jsonView", $action, $app, $parameters );
} )->via ( "GET", "POST", "PUT", "DELETE" );

/**
 * Map for routing players table search
 *
 * @param playerid slim used for requests
 *
 * @return loadRunMVCComponents generates MVC components for GET
 */

$app->map ( "/players/search/:SearchingString", "authenticate", function ($searchString = null) use($app) {
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["SearchingString"] = $searchString;
	if (!$searchString == null) {
		switch ($httpMethod) {
			case "GET" :
				if ($searchString != null)
					$action = ACTION_SEARCH_PLAYERS;
					break;
		}
	}
	return new loadRunMVCComponents ( "PlayerModel", "PlayerController", "jsonView", $action, $app, $parameters );
} )->via ( "GET" );


$app->run ();

/**
 * class that contructs MVC elements for the service
 *
 * @param $modelName 
 * @param $controllerName
 * @param $viewName
 * @param $action
 * @param $app
 * @param $parameters
 */

class loadRunMVCComponents {
	public $model, $controller, $view;
	public function __construct($modelName, $controllerName, $viewName, $action, $app, $parameters = null) {
		include_once "models/" . $modelName . ".php";
		include_once "controllers/" . $controllerName . ".php";
		include_once "views/" . $viewName . ".php";
		
		$model = new $modelName (); // common model
		$controller = new $controllerName ( $model, $action, $app, $parameters );
		$view = new $viewName ( $controller, $model, $app, $app->headers ); // common view

		$contentType = $app->request->getContentType();
		
		if($contentType == "application/xml"){
			$view->outputXML ();
		}
		else
		{
			$view->outputJSON ();
		}
		
	}
}

?>