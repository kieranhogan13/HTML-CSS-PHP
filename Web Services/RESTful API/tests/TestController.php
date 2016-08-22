<?php
/*
 * @version 1.0.0
 * @author Kieran Hogan <c12561353@mydit.ie>
 */
require_once "../app/DB/pdoDbManager.php";
require_once "../app/DB/DAO/PlayersDAO.php";
require_once "../app/conf/config.inc.php";
require_once ('../simpletest/autorun.php');

class TestController extends UnitTestCase
{
	private $slimApp;
	private $model;
	private $requestBody;
	private $controller;
	public function setUp()
	{
// 		require_once ('../app/controllers/Controller.php');
//  		$this->controller = new Controller(model, slimApp);
	}
	
	public function tearDown()
	{
// 		$this->controller = NULL ;
	}
	
	public function testGetResponses()
	{
// 		$result = $this->controller->getResponse(NULL);
// 		$this->assertTrue($result);
// 		$array = array("name"=>"test", "surname"=>"test", "age"=>"15", "nationality"=>"test", "team"=>"1");
// 		$id = $this->playerModel->createNewPlayer($array);
// 		$array = array("id" => $id) + $array;			
// 		$this->assertEqual($array, $this->playerModel->getPlayer($id)[0]);
		
// 		$this->assertFalse($this->playerModel->getPlayer(-1));
	}
	
	public function testGetResponse()
	{
		// 		$array = array("name"=>"test", "surname"=>"test", "age"=>"15", "nationality"=>"test", "team"=>"1");
		// 		$id = $this->playerModel->createNewPlayer($array);
		// 		$array = array("id" => $id) + $array;
		// 		$this->assertEqual($array, $this->playerModel->getPlayer($id)[0]);
	
		// 		$this->assertFalse($this->playerModel->getPlayer(-1));
	}
	
	public function testCreateNewResponses()
	{
		// 		$array = array("name"=>"test", "surname"=>"test", "age"=>"15", "nationality"=>"test", "team"=>"1");
		// 		$id = $this->playerModel->createNewPlayer($array);
		// 		$array = array("id" => $id) + $array;
		// 		$this->assertEqual($array, $this->playerModel->getPlayer($id)[0]);
	
		// 		$this->assertFalse($this->playerModel->getPlayer(-1));
	}
	
	public function testDeleteResponse()
	{
		// 		$array = array("name"=>"test", "surname"=>"test", "age"=>"15", "nationality"=>"test", "team"=>"1");
		// 		$id = $this->playerModel->createNewPlayer($array);
		// 		$array = array("id" => $id) + $array;
		// 		$this->assertEqual($array, $this->playerModel->getPlayer($id)[0]);
	
		// 		$this->assertFalse($this->playerModel->getPlayer(-1));
	}
	
	public function testSearchResponse()
	{
		// 		$array = array("name"=>"test", "surname"=>"test", "age"=>"15", "nationality"=>"test", "team"=>"1");
		// 		$id = $this->playerModel->createNewPlayer($array);
		// 		$array = array("id" => $id) + $array;
		// 		$this->assertEqual($array, $this->playerModel->getPlayer($id)[0]);
	
		// 		$this->assertFalse($this->playerModel->getPlayer(-1));
	}
}
?>