<?php
/**
 * @version 1.0.
 * @author Kieran Hogan kieran.hogan3@student.dit.ie
 */

/**
 * DAO for the players
 */
 
class PlayersDAO {
	private $dbManager;
	function PlayersDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	
	/**
	 * Function for executing get players query
	 *
	 * @param int id
	 */
	public function get($id = null) {
		$sql = "SELECT * ";
		$sql .= "FROM players ";
		if ($id != null)
			$sql .= "WHERE players.id=? ";
		$sql .= "ORDER BY players.name ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $id, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
	
	/**
	 * Function for executing insert players query
	 *
	 * @param array parameters of new insert
	 */
	public function insert($parametersArray) {
		// insertion assumes that all the required parameters are defined and set
		$sql = "INSERT INTO players (name, surname, age, nationality, team) ";
		$sql .= "VALUES (?,?,?,?,?) ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["name"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["surname"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["age"], $this->dbManager->INT_TYPE );
		$this->dbManager->bindValue ( $stmt, 4, $parametersArray ["nationality"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 5, $parametersArray ["team"], $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		
		return ($this->dbManager->getLastInsertedID ());
	}
	
	/**
	 * Function for executing update players query
	 *
	 * @param int id
	 * @param array new parameters
	 */
	public function update($parametersArray, $playerId) {
		$sql = "UPDATE players
				SET name = ?, surname = ?, age = ?, nationality = ?, team = ?
				WHERE ID = ?";
		$stmt = $this->dbManager->prepareQuery( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["name"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["surname"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["age"], $this->dbManager->INT_TYPE );
		$this->dbManager->bindValue ( $stmt, 4, $parametersArray ["nationality"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 5, $parametersArray ["team"], $this->dbManager->INT_TYPE );
		$this->dbManager->bindValue ( $stmt, 6, $playerId, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		
		return ($this->dbManager->getNumberOfAffectedRows($stmt));
	}
	
	/**
	 * Function for executing delete players query
	 *
	 * @param int id
	 */
	public function delete($playerId) {
		$sql = "DELETE ";
		$sql .= "FROM players ";
		$sql .= "WHERE ID = ?";
		$this->dbManager->openConnection();
		$stmt = $this->dbManager->prepareQuery( $sql );
		$this->dbManager-> bindValue($stmt, 1, $playerId, $this->dbManager->STRING_TYPE);
		$this->dbManager->executeQuery ( $stmt );
		
		return ($this->dbManager->getNumberOfAffectedRows($stmt));
	}
	
	/**
	 * Function for executing search players query
	 *
	 * @param string first/lastname
	 */
	public function search($string) {
		$string = '%' . $string . '%';
		$sql = "SELECT * ";
		$sql .= "FROM players ";
		$sql .= "WHERE name LIKE ? OR surname LIKE ?";
		$this->dbManager->openConnection();
		$statement = $this->dbManager->prepareQuery( $sql );
		$this->dbManager-> bindValue($statement, 1, $string, $this->dbManager->STRING_TYPE);
		$this->dbManager-> bindValue($statement, 2, $string, $this->dbManager->STRING_TYPE);
		$this->dbManager->executeQuery ( $statement );
		$arrayOfResults = $this->dbManager->fetchResults ($statement);
		return $arrayOfResults;
	}	
}
?>
