<?php
/*
 * @version 1.0.0
 * @author Ben Creasey <ben.creasey@mydit.ie>
 */
require_once "../app/DB/pdoDbManager.php";
require_once "../app/DB/DAO/TeamsDAO.php";
require_once "../app/conf/config.inc.php";
require_once ('../simpletest/autorun.php');

class TestTeamModel extends UnitTestCase
{
	private $teamModel;
	public function setUp()
	{
		require_once ('../app/models/TeamModel.php');
		$this->teamModel = new TeamModel();
	}
	
	public function tearDown()
	{
		$this->teamModel = NULL ;
	}
	
	public function testGetTeams()
	{
		$teams = count($this->teamModel->getTeams());
		$insert = array("name"=>"test", "city"=>"test", "country"=>"test", "info"=>"test");
		$this->teamModel->createNewTeam($insert);
		$teamsNew = count($this->teamModel->getTeams());
		$this->assertEqual($teams + 1, $teamsNew);
	}
	
	public function testGetTeam()
	{
		$array = array("name"=>"test", "city"=>"test", "country"=>"test", "info"=>"test");
		$id = $this->teamModel->createNewTeam($array);
		$array = array("id" => $id) + $array;			
		$this->assertEqual($array, $this->teamModel->getTeam($id)[0]);
		
		$this->assertFalse($this->teamModel->getTeam(-1));
		
	}
	
	public function testCreateNewTeam()
	{
		$array = array("name"=>"test", "city"=>"test", "country"=>"test", "info"=>"test");
		$result = $this->teamModel->createNewTeam($array);
		$this->assertTrue(is_numeric($result));
		
		$array = array("name"=>"", "city"=>"test", "country"=>"test", "info"=>"test");
		$result = $this->teamModel->createNewTeam($array);
		$this->assertFalse($result);
		
		$array = array("name"=>"test", "city"=>"", "country"=>"test", "info"=>"test");
		$result = $this->teamModel->createNewTeam($array);
		$this->assertFalse($result);
		
		$array = array("name"=>"test", "city"=>"test", "country"=>"", "info"=>"test");
		$result = $this->teamModel->createNewTeam($array);
		$this->assertFalse($result);
		
		$array = array("name"=>"test", "city"=>"test", "country"=>"test", "info"=>"");
		$result = $this->teamModel->createNewTeam($array);
		$this->assertFalse($result);
		
		$array = array("name"=>true, "city"=>"test", "country"=>"test", "info"=>"");
		$result = $this->teamModel->createNewTeam($array);
		$this->assertFalse($result);
	}
	
	public function testUpdateTeams()
	{
		$id = 1;
		$array = array("name"=>"testtest", "city"=>"test", "country"=>"test", "info"=>"test");
		$result = $this->teamModel->updateTeams($id, $array);
		$this->assertEqual(1, $result);
		
		$id = 1;
		$array = array("name"=>"testupdate", "city"=>"test", "country"=>"test", "info"=>"test");
		$result = $this->teamModel->updateTeams($id, $array);
		$this->assertEqual(1, $result);
	}
	
	public function testSearchTeams()
	{
		$string = "testupdate";
		$search = $this->teamModel->searchTeams($string);
		$this->assertTrue($search);
		
		$string = "updatetest1111";
		$search = $this->teamModel->searchTeams($string);
		$this->assertFalse($search);
		
		$string = "";
		$search = $this->teamModel->searchTeams($string);
		$this->assertFalse($search);
		
		$string = 1;
		$search = $this->teamModel->searchTeams($string);
		$this->assertFalse($search);
		
		$string = NULL;
		$search = $this->teamModel->searchTeams($string);
		$this->assertFalse($search);
		
	}
	
	public function testDeleteTeam()
	{
		$array = array("name"=>"test", "city"=>"test", "country"=>"test", "info"=>"test");
		$result = $this->teamModel->createNewTeam($array);
		$this->teamModel->deleteTeam($result);
		$this->assertFalse($this->teamModel->getTeam($result));
	}
}

?>