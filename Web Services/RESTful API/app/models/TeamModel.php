<?php

/**
 * @version 1.0.
 * @author Kieran Hogan kieran.hogan3@student.dit.ie
 */

/**
 * Model for the teams
 */
require_once "../app/DB/pdoDbManager.php";
require_once "../app/DB/DAO/TeamsDAO.php";
require_once "Validation.php";

class TeamModel {
	private $TeamsDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response
	private $validationSuite; // contains functions for validating inputs
	
	/**
	 * Function for constructing DAO, pdo and validation
	 */
	public function __construct() {
		$this->dbmanager = new pdoDbManager ();
		$this->TeamsDAO = new TeamsDAO ( $this->dbmanager );
		$this->dbmanager->openConnection ();
		$this->validationSuite = new Validation ();
	}
	
	/**
	 * Function for retrieving all models
	 *
	 * @return get runs query from dao
	 */
	public function getTeams() {
		return ($this->TeamsDAO->get ());
	}

	/**
	 * Function for retrieving teams by id
	 *
	 * @param playerid id thats searched for
	 *
	 * @return get runs query from dao
	 * @return bool on failure
	 */
	public function getTeam($teamId) {
		if (is_numeric ( $teamId ))
			return ($this->TeamsDAO->get ( $teamId ));
		
		return false;
	}
	/**
	 * Function for creating new teams
	 * 
	 * @param array $newTeam:
	 *        	an associative array containing the detail of the new team
	 */
	public function createNewTeam($newTeam) {
		// validation of the values of the new team
		
		// compulsory values
		if (! empty ( $newTeam ["name"] ) && ! empty ( $newTeam ["city"] ) && ! empty ( $newTeam ["country"] ) && ! empty ( $newTeam ["info"] )) {
			/*
			 * the model knows the representation of a team in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
			 */
			
			if (($this->validationSuite->isLengthStringValid ( $newTeam ["name"], TABLE_TEAM_NAME_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $newTeam ["city"], TABLE_TEAM_CITY_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $newTeam ["country"], TABLE_TEAM_COUNTRY_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $newTeam["info"], TABLE_TEAM_INFO_LENGTH ))) {
				if ($newId = $this->TeamsDAO->insert ( $newTeam ))
					return ($newId);
			}
		}
		
		// if validation fails or insertion fails
		return (false);
	}
	public function updateTeams($teamId, $teamNewRepresentation) {
		if (! empty ($teamId))
			if (! empty ( $teamNewRepresentation ["name"] ) && ! empty ( $teamNewRepresentation ["city"] ) && ! empty ( $teamNewRepresentation ["country"] ) && ! empty ( $teamNewRepresentation ["info"] )) {
			/*
			 * the model knows the representation of a team in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
			 */
			
			if (($this->validationSuite->isLengthStringValid ( $teamNewRepresentation ["name"], TABLE_TEAM_NAME_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $teamNewRepresentation ["city"], TABLE_TEAM_CITY_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $teamNewRepresentation ["country"], TABLE_TEAM_COUNTRY_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $teamNewRepresentation ["info"], TABLE_TEAM_INFO_LENGTH ))) {
				if ($teamId = $this->TeamsDAO->update ( $teamNewRepresentation, $teamId ))
					return ($teamId);
			}
		}
		
		// if validation fails or insertion fails
		return (false);
	}
	public function searchTeams($searchString) {
		if (!empty ($searchString))
		{
			if (!empty ($searchString))
			{
				return($this->TeamsDAO->search($searchString));
			}
		}
		return (false);
	}
	
	public function deleteTeam($teamId) {
		if (! empty ($teamId) && is_numeric($teamId))
		{
			if($teamId =$this->TeamsDAO->delete($teamId))
			{
				return ($teamId);
			}
		}
		return (false);
	}
	public function __destruct() {
		$this->TeamsDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>