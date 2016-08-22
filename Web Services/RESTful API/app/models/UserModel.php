<?php

/**
 * @version 1.0.
 * @author Kieran Hogan kieran.hogan3@student.dit.ie
 */

/**
 * Model for the users
 */
require_once "../app/DB/pdoDbManager.php";
require_once "../app/DB/DAO/UsersDAO.php";
require_once "Validation.php";
class UserModel {
	private $UsersDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response
	private $validationSuite; // contains functions for validating inputs
	
	/**
	 * Function for constructing DAO, pdo and validation
	 */
	public function __construct() {
		$this->dbmanager = new pdoDbManager ();
		$this->UsersDAO = new UsersDAO ( $this->dbmanager );
		$this->dbmanager->openConnection ();
		$this->validationSuite = new Validation ();
	}
	
	/**
	 * Function for retrieving all users
	 *
	 * @return get runs query from dao
	 */
	public function getUsers() {
		return ($this->UsersDAO->get ());
	}

	/**
	 * Function for retrieving users by id
	 *
	 * @param playerid id thats searched for
	 *
	 * @return get runs query from dao
	 * @return bool on failure
	 */
	public function getUser($userId) {
		if (is_numeric ( $userId ))
			return ($this->UsersDAO->get ( $userId ));
		
		return false;
	}
	/**
	 * Function for creating new users
	 * 
	 * @param array $newUser:
	 *        	an associative array containing the detail of the new user
	 */
	public function createNewUser($newUser) {
		// validation of the values of the new user
		
		// compulsory values
		if (! empty ( $newUser ["name"] ) && ! empty ( $newUser ["surname"] ) && ! empty ( $newUser ["email"] ) && ! empty ( $newUser ["password"] )) {
			/*
			 * the model knows the representation of a user in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
			 */
			
			if (($this->validationSuite->isLengthStringValid ( $newUser ["name"], TABLE_USER_NAME_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $newUser ["surname"], TABLE_USER_SURNAME_LENGTH )) && ($this->validationSuite->isEmailValid ( $newUser ["email"], TABLE_USER_EMAIL_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $newUser ["password"], TABLE_USER_PASSWORD_LENGTH ))) {
				// EXTRA FUNCTIONALITY, disabled
				//$password = hash("sha256", $password, FALSE);
				if ($newId = $this->UsersDAO->insert ( $newUser ))
					return ($newId);
			}
		}
		
		// if validation fails or insertion fails
		return (false);
	}
	
	/**
	 * Function for updating new users
	 *
	 * @param array $UserRepresentation:
	 *        	an associative array containing the detail of the new user
	 * @param int id of user to update
	 */
	public function updateUsers($userId, $userNewRepresentation) {
		if (! empty ($userId))
			if (! empty ( $userNewRepresentation ["name"] ) && ! empty ( $userNewRepresentation ["surname"] ) && ! empty ( $userNewRepresentation ["email"] ) && ! empty ( $userNewRepresentation ["password"] )) {
			/*
			 * the model knows the representation of a user in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
			 */
			
			if (($this->validationSuite->isLengthStringValid ( $userNewRepresentation ["name"], TABLE_USER_NAME_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $userNewRepresentation ["surname"], TABLE_USER_SURNAME_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $userNewRepresentation ["email"], TABLE_USER_EMAIL_LENGTH )) && ($this->validationSuite->isLengthStringValid ( $userNewRepresentation ["password"], TABLE_USER_PASSWORD_LENGTH ))) {
				if ($userId = $this->UsersDAO->update ( $userNewRepresentation, $userId ))
					return ($userId);
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
	public function searchUsers($searchString) {
		if (!empty ($searchString))
		{
			if (!empty ($searchString))
			{
				return($this->UsersDAO->search($searchString));
			}
		}
		return (false);
	}
	
	/**
	 * Function for deleting players by id
	 *
	 * @param int id
	 */
	public function deleteUser($userId) {
		if (! empty ($userId) && is_numeric($userId))
		{
			if($userId =$this->UsersDAO->delete($userId))
			{
				return ($userId);
			}
		}
		return (false);
	}
	
	/**
	 * Function for destroying DAO
	 */
	public function __destruct() {
		$this->UsersDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>