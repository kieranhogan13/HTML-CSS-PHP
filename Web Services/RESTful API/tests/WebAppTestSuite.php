<?php
/*
 * @version 1.0.0
 * @author Ben Creasey <ben.creasey@mydit.ie>
 */
require_once('../simpletest/autorun.php');
class WebAppTestSuite extends TestSuite {
	function __construct(){
		parent::__construct();
		$this->addFile("TestUserModel.php");
		$this->addFile("TestPlayerModel.php");
		$this->addFile("TestTeamModel.php");
		$this->addFile("TestValidation.php");
	}

}
?>