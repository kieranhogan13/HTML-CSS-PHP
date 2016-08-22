<?php
 
/**
 * @version 1.0.
 * @author Kieran Hogan kieran.hogan3@student.dit.ie
 */

/**
 * DAO for the teams
 */
class TeamsDAO {
	private $dbManager;
	function TeamsDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	

	/**
	 * Function for executing get teams query
	 *
	 * @param int id
	 */
	public function get($id = null) {
		$sql = "SELECT * ";
		$sql .= "FROM teams ";
		if ($id != null)
			$sql .= "WHERE teams.id=? ";
		$sql .= "ORDER BY teams.name ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $id, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
	

	/**
	 * Function for executing insert teams query
	 *
	 * @param array parameters of new insert
	 */
	public function insert($parametersArray) {
		// insertion assumes that all the required parameters are defined and set
		$sql = "INSERT INTO teams (name, city, country, info) ";
		$sql .= "VALUES (?,?,?,?) ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["name"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["city"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["country"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 4, $parametersArray ["info"], $this->dbManager->STRING_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		
		return ($this->dbManager->getLastInsertedID ());
	}
	

	/**
	 * Function for executing update teams query
	 *
	 * @param int id
	 * @param array new parameters
	 */
	public function update($parametersArray, $teamId) {
		$sql = "UPDATE teams
				SET name = ?, city = ?, country = ?, info = ? 
				WHERE ID = ?";
		$stmt = $this->dbManager->prepareQuery( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["name"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["city"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["country"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 4, $parametersArray ["info"], $this->dbManager->STRING_TYPE );
		$this->dbManager-> bindValue($stmt, 5, $teamId, PDO::PARAM_STR);
		$this->dbManager->executeQuery ( $stmt );
		
		return ($this->dbManager->getNumberOfAffectedRows($stmt));
	}
	

	/**
	 * Function for executing delete teams query
	 *
	 * @param int id
	 */
	public function delete($teamId) {
		$sql = "DELETE ";
		$sql .= "FROM teams ";
		$sql .= "WHERE ID = ?";
		$this->dbManager->openConnection();
		$stmt = $this->dbManager->prepareQuery( $sql );
		$this->dbManager-> bindValue($stmt, 1, $teamId, PDO::PARAM_INT);
		$this->dbManager->executeQuery ( $stmt );
		
		return ($this->dbManager->getNumberOfAffectedRows($stmt));
	}
	

	/**
	 * Function for executing search teams query
	 *
	 * @param string name/city
	 */
	public function search($string) {
		$string = '%' . $string . '%';
		$sql = "SELECT * ";
		$sql .= "FROM teams ";
		$sql .= "WHERE name LIKE ? OR city LIKE ?";
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
