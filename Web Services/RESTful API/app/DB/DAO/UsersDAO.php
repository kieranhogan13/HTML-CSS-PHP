<?php
/**
 * @version 1.0.
 * @author Kieran Hogan kieran.hogan3@student.dit.ie
 */

/**
 * DAO for the users
 */
 
class UsersDAO {
	private $dbManager;
	function UsersDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	
	/**
	 * Function for executing get users query
	 *
	 * @param int id
	 */
	public function get($id = null) {
		$sql = "SELECT * ";
		$sql .= "FROM users ";
		if ($id != null)
			$sql .= "WHERE users.id=? ";
		$sql .= "ORDER BY users.name ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $id, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
	
	/**
	 * Function for executing insert users query
	 *
	 * @param array parameters of new insert
	 */
	public function insert($parametersArray) {
		// insertion assumes that all the required parameters are defined and set
		$sql = "INSERT INTO users (name, surname, email, password) ";
		$sql .= "VALUES (?,?,?,?) ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["name"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["surname"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["email"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 4, $parametersArray ["password"], $this->dbManager->STRING_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		
		return ($this->dbManager->getLastInsertedID ());
	}
	
	/**
	 * Function for executing update users query
	 *
	 * @param int id
	 * @param array new parameters
	 */
	public function update($parametersArray, $userId) {
		$sql = "UPDATE users
				SET name = ?, surname = ?, email = ?, password = ? 
				WHERE ID = ?";
		$stmt = $this->dbManager->prepareQuery( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["name"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["surname"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["email"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 4, $parametersArray ["password"], $this->dbManager->STRING_TYPE );
		$this->dbManager-> bindValue($stmt, 5, $userId, PDO::PARAM_STR);
		$this->dbManager->executeQuery ( $stmt );
		
		return ($this->dbManager->getNumberOfAffectedRows($stmt));
	}
	
	/**
	 * Function for executing delete users query
	 *
	 * @param int id
	 */
	public function delete($userId) {
		$sql = "DELETE ";
		$sql .= "FROM users ";
		$sql .= "WHERE ID = ?";
		$this->dbManager->openConnection();
		$stmt = $this->dbManager->prepareQuery( $sql );
		$this->dbManager-> bindValue($stmt, 1, $userId, $this->dbManager->STRING_TYPE);
		$this->dbManager->executeQuery ( $stmt );
		
		return ($this->dbManager->getNumberOfAffectedRows($stmt));
	}
	
	/**
	 * Function for executing search users query
	 *
	 * @param string first/lastname
	 */
	public function search($string) {
		$string = '%' . $string . '%';
		$sql = "SELECT * ";
		$sql .= "FROM users ";
		$sql .= "WHERE name LIKE ? OR surname LIKE ?";
		$this->dbManager->openConnection();
		$statement = $this->dbManager->prepareQuery( $sql );
		$this->dbManager-> bindValue($statement, 1, $string, PDO::PARAM_STR);
		$this->dbManager-> bindValue($statement, 2, $string, PDO::PARAM_STR);
		$this->dbManager->executeQuery ( $statement );
		$arrayOfResults = $this->dbManager->fetchResults ($statement);
		return $arrayOfResults;
	}	
}
?>
