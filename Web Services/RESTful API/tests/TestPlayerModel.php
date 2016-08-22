<?php
/*
 * @version 1.0.0
 * @author Ben Creasey <ben.creasey@mydit.ie>
 */
require_once "../app/DB/pdoDbManager.php";
require_once "../app/DB/DAO/PlayersDAO.php";
require_once "../app/conf/config.inc.php";
require_once ('../simpletest/autorun.php');

class TestPlayerModel extends UnitTestCase
{
	private $playerModel;
	public function setUp()
	{
		require_once ('../app/models/PlayerModel.php');
		$this->playerModel = new PlayerModel();
	}
	
	public function tearDown()
	{
		$this->playerModel = NULL ;
	}
	
	public function testGetPlayer()
	{
		$array = array("name"=>"test", "surname"=>"test", "age"=>"15", "nationality"=>"test", "team"=>"1");
		$id = $this->playerModel->createNewPlayer($array);
		$array = array("id" => $id) + $array;			
		$this->assertEqual($array, $this->playerModel->getPlayer($id)[0]);
		
		$this->assertFalse($this->playerModel->getPlayer(-1));		
	}
	
	public function testGetPlayers()
	{
		$players = count($this->playerModel->getPlayers());
		$insert = array("name"=>"test", "surname"=>"test", "age"=>"15", "nationality"=>"test", "team"=>"1");
		$this->playerModel->createNewPlayer($insert);
		$playersNew = count($this->playerModel->getPlayers());
		$this->assertEqual($players + 1, $playersNew);
	}
	
	public function testCreateNewPlayer()
	{
		$array = array("name"=>"test", "surname"=>"test", "age"=>"15", "nationality"=>"test", "team"=>"1");
		$result = $this->playerModel->createNewPlayer($array);
		$this->assertTrue(is_numeric($result));
		
		$array = array("name"=>"test", "surname"=>"test", "age"=>"fifteen", "nationality"=>"test", "team"=>"1");
		$result = $this->playerModel->createNewPlayer($array);
		$this->assertFalse($result);
		
		$array = array("name"=>"", "surname"=>"test", "age"=>"15", "nationality"=>"test", "team"=>"1");
		$result = $this->playerModel->createNewPlayer($array);
		$this->assertFalse($result);
		
		$array = array("name"=>true, "surname"=>"test", "age"=>"15", "nationality"=>"test", "team"=>"1");
		$result = $this->playerModel->createNewPlayer($array);
		$this->assertFalse($result);
		
		$array = array("name"=>"test", "surname"=>"test", "age"=>false, "nationality"=>"test", "team"=>"1");
		$result = $this->playerModel->createNewPlayer($array);
		$this->assertFalse($result);
		
		$array = array("name"=>"test", "surname"=>"test", "age"=>"15", "nationality"=>"test", "team"=>"Chelsea");
		$result = $this->playerModel->createNewPlayer($array);
		$this->assertFalse($result);

	}
	
	public function testUpdatePlayers()
	{
		$id = 50;
		$array = array("name"=>"netest", "surname"=>"surtest", "age"=>"15", "nationality"=>"test", "team"=>"1");
		$result = $this->playerModel->updatePlayers($id, $array);
		$this->assertEqual(1, $result);
		
		$id = 50;
		$array = array("name"=>"updatetest", "surname"=>"surtest", "age"=>"15", "nationality"=>"test", "team"=>"1");
		$result = $this->playerModel->updatePlayers($id, $array);
		$this->assertEqual(1, $result);
		
		$id = 50;
		$array = array("name"=>"", "surname"=>"surtest", "age"=>"15", "nationality"=>"test", "team"=>"1");
		$result = $this->playerModel->updatePlayers($id, $array);
		$this->assertFalse( $result);
		
		$id = 50;
		$array = array("name"=>"updatetest", "surname"=>"", "age"=>"15", "nationality"=>"test", "team"=>"1");
		$result = $this->playerModel->updatePlayers($id, $array);
		$this->assertFalse( $result);
		
		$id = 50;
		$array = array("name"=>"updatetest", "surname"=>"surtest", "age"=>"", "nationality"=>"test", "team"=>"1");
		$result = $this->playerModel->updatePlayers($id, $array);
		$this->assertFalse( $result);
		
		$id = 50;
		$array = array("name"=>"updatetest", "surname"=>"surtest", "age"=>"15", "nationality"=>"", "team"=>"1");
		$result = $this->playerModel->updatePlayers($id, $array);
		$this->assertFalse( $result);
		
		$id = 50;
		$array = array("name"=>"updatetest", "surname"=>"surtest", "age"=>"15", "nationality"=>"test", "team"=>"");
		$result = $this->playerModel->updatePlayers($id, $array);
		$this->assertFalse( $result);
		
		$id = 50;
		$array = array("name"=>"updatetest", "surname"=>"surtest", "age"=>"15", "nationality"=>"test", "team"=>"Chelsea");
		$result = $this->playerModel->updatePlayers($id, $array);
		$this->assertFalse( $result);
		
	}
	
	public function testSearchPlayers()
	{
		$string = "updatetest";
		$search = $this->playerModel->searchPlayers($string);
		$this->assertTrue($search);
		
		$string = "updatetest1111";
		$search = $this->playerModel->searchPlayers($string);
		$this->assertFalse($search);
		
		$string = "";
		$search = $this->playerModel->searchPlayers($string);
		$this->assertFalse($search);
		
		$string = 24;
		$search = $this->playerModel->searchPlayers($string);
		$this->assertFalse($search);
		
		$string = NULL;
		$search = $this->playerModel->searchPlayers($string);
		$this->assertFalse($search);
		
		$string = true;
		$search = $this->playerModel->searchPlayers($string);
		$this->assertFalse($search);		
	}
	
	public function testDeletePlayer()
	{
		$array = array("name"=>"test", "surname"=>"test", "age"=>"15", "nationality"=>"test", "team"=>"1");
		$result = $this->playerModel->createNewPlayer($array);
		$this->playerModel->deletePlayer($result);
		$this->assertFalse($this->playerModel->getPlayer($result));
	}
}

?>