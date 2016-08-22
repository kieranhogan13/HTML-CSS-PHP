<?php

/**
 * @version 1.0.
 * @author Kieran Hogan kieran.hogan3@student.dit.ie
 */

/**
 * Model for the players
 */
require_once "../app/DB/pdoDbManager.php";
require_once "../app/DB/DAO/PlayersDAO.php";
require_once "Validation.php";

class PlayerModel {
	private $PlayersDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response
	private $validationSuite; // contains functions for validating inputs
	
	/**
	 * Function for constructing DAO, pdo and validation
	 */
	public function __construct() {
		$this->dbmanager = new pdoDbManager ();
		$this->PlayersDAO = new PlayersDAO ( $this->dbmanager );
		$this->dbmanager->openConnection ();
		$this->validationSuite = new Validation ();
	}
	
	/**
	 * Function for retrieving all players
	 *
	 * @return get runs query from dao
	 */
	public function getPlayers() {
		return ($this->PlayersDAO->get ());
	}
	
	/**
	 * Function for retrieving players by id
	 *
	 * @param playerid id thats searched for
	 *
	 * @return get runs query from dao
	 * @return bool on failure
	 */
	public function getPlayer($playerId) {
		if (is_numeric ( $playerId ))
			return ($this->PlayersDAO->get ( $playerId ));
		
		return false;
	}
	
	/**
	 * Function for creating new players
	 * 
	 * @param array $newPlayer:
	 *        	an associative array containing the detail of the new player
	 */
	public function createNewPlayer($newPlayer) {
		// validation of the values of the new team
		
		// compulsory values
		if (! empty ( $newPlayer ["name"] ) && ! empty ( $newPlayer ["surname"] ) && ! empty ( $newPlayer ["age"] ) && ! empty ( $newPlayer ["nationality"] ) && ! empty ( $newPlayer ["team"] )) {
			/*
			 * the model knows the representation of a team in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
			 */
			
			if (($this->validationSuite->isLengthStringValid ( $newPlayer ["name"], TABLE_PLAYER_NAME_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $newPlayer ["surname"], TABLE_PLAYER_SURNAME_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $newPlayer["nationality"], TABLE_PLAYER_NATIONALITY_LENGTH )) ) {
				if(($this->validationSuite->isNumberInRangeValid ($newPlayer ["age"], TABLE_PLAYER_AGE_LENGTH_MIN, TABLE_PLAYER_AGE_LENGTH_MAX)) && ($this->validationSuite->isNumberInRangeValid ($newPlayer ["team"], TABLE_PLAYER_TEAM_LENGTH_MIN, TABLE_PLAYER_TEAM_LENGTH_MAX))){
					if ($newId = $this->PlayersDAO->insert ( $newPlayer ))
						return ($newId);
				}
			}
		}
		
		// if validation fails or insertion fails
		return (false);
	}
	
	/**
	 * Function for updating new players
	 *
	 * @param array $TeamRepresentation:
	 *        	an associative array containing the detail of the new player
	 * @param int id of player to update       
	 */
	public function updatePlayers($playerId, $playerNewRepresentation) {
		
		if (! empty ($playerId))
			if (! empty ( $playerNewRepresentation ["name"] ) && ! empty ( $playerNewRepresentation ["surname"] ) && ! empty ( $playerNewRepresentation ["nationality"] )) {
			/*
			 * the model knows the representation of a team in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
			 */
			
			if (($this->validationSuite->isLengthStringValid ( $playerNewRepresentation ["name"], TABLE_PLAYER_NAME_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $playerNewRepresentation ["surname"], TABLE_PLAYER_SURNAME_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $playerNewRepresentation["nationality"], TABLE_PLAYER_NATIONALITY_LENGTH )) ) {
				if(($this->validationSuite->isNumberInRangeValid ($playerNewRepresentation ["age"], TABLE_PLAYER_AGE_LENGTH_MIN, TABLE_PLAYER_AGE_LENGTH_MAX)) && ($this->validationSuite->isNumberInRangeValid ($playerNewRepresentation ["team"], TABLE_PLAYER_TEAM_LENGTH_MIN, TABLE_PLAYER_TEAM_LENGTH_MAX))){
					if ($playerId = $this->PlayersDAO->update ( $playerNewRepresentation, $playerId ))
						return ($playerId);
				}
			}
		}
		
		// if validation fails or insertion fails
		return (false);
	}
	
	/**
	 * Function for searching for players by first/lastname
	 *
	 * @param string of search
	 */
	public function searchPlayers($searchString) {
		if (!empty ($searchString))
		{
			if (!empty ($searchString))
			{
				return($this->PlayersDAO->search($searchString));
			}
		}
		return (false);
	}
	
	/**
	 * Function for deleting players by id
	 *
	 * @param int id
	 */
	public function deletePlayer($playerId) {
		if (! empty ($playerId) && is_numeric($playerId))
		{
			if($playerId =$this->PlayersDAO->delete($playerId))
			{
				return ($playerId);
			}
		}
		return (false);
	}
	
	/**
	 * Function for destroying DAO
	 */
	public function __destruct() {
		$this->PlayersDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>