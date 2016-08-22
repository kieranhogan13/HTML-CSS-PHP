<?php
/*
 * @version 1.0.0
 * @author Ben Creasey <ben.creasey@mydit.ie>
 */
require_once "../app/DB/pdoDbManager.php";
require_once "../app/DB/DAO/usersDAO.php";
require_once "../app/conf/config.inc.php";
require_once ('../simpletest/autorun.php');

class TestUserModel extends UnitTestCase
{
	private $userModel;
	public function setUp()
	{
		require_once ('../app/models/userModel.php');
		$this->userModel = new userModel();
	}
	
	public function tearDown()
	{
		$this->userModel = NULL ;
	}
	
	public function testGetuser()
	{
		$array = array("name"=>"test", "surname"=>"test", "email"=>"test@gmail.com", "password"=>"password");
		$id = $this->userModel->createNewUser($array);
		$array = array("id" => $id) + $array;			
		$this->assertEqual($array, $this->userModel->getuser($id)[0]);
		
		$this->assertFalse($this->userModel->getuser(-1));
		
	}
	
	public function testGetusers()
	{
		$users = count($this->userModel->getusers());
		$insert = array("name"=>"test", "surname"=>"test", "email"=>"test@gmail.com", "password"=>"password");
		$this->userModel->createNewuser($insert);
		$usersNew = count($this->userModel->getusers());
		$this->assertEqual($users + 1, $usersNew);
	}
	
	public function testCreateNewuser()
	{
		$array = array("name"=>"test", "surname"=>"test", "email"=>"test@gmail.com", "password"=>"password");
		$result = $this->userModel->createNewUser($array);
		$this->assertTrue(is_numeric($result));
		
		$array = array("name"=>"", "surname"=>"test", "email"=>"test@gmail.com", "password"=>"password");
		$result = $this->userModel->createNewUser($array);
		$this->assertFalse($result);
		
		$array = array("name"=>"test", "surname"=>"", "email"=>"test@gmail.com", "password"=>"password");
		$result = $this->userModel->createNewUser($array);
		$this->assertFalse($result);
		
		$array = array("name"=>"test", "surname"=>"test", "email"=>"", "password"=>"password");
		$result = $this->userModel->createNewUser($array);
		$this->assertFalse($result);
		
		$array = array("name"=>"test", "surname"=>"test", "email"=>"test@gmail.com", "password"=>"");
		$result = $this->userModel->createNewUser($array);
		$this->assertFalse($result);
		
		$array = array("name"=>false, "surname"=>"test", "email"=>"test@gmail.com", "password"=>"");
		$result = $this->userModel->createNewUser($array);
		$this->assertFalse($result);
	}
	
	public function testUpdateUsers()
	{
		$id = 50;
		$array = array("name"=>"updatetest", "surname"=>"test", "email"=>"test@gmail.com", "password"=>"password");
		$result = $this->userModel->updateUsers($id, $array);
		$this->assertEqual(1, $result);
		
		$id = 50;
		$array = array("name"=>"updatetest111", "surname"=>"test", "email"=>"test@gmail.com", "password"=>"password");
		$result = $this->userModel->updateUsers($id, $array);
		$this->assertEqual(1, $result);
		
		$id = 50;
		$array = array("name"=>"", "surname"=>"test", "email"=>"test@gmail.com", "password"=>"password");
		$result = $this->userModel->updateUsers($id, $array);
		$this->assertFalse($result);
		
		$id = 50;
		$array = array("name"=>"updatetest111", "surname"=>"", "email"=>"test@gmail.com", "password"=>"password");
		$result = $this->userModel->updateUsers($id, $array);
		$this->assertFalse($result);
		
		$id = 50;
		$array = array("name"=>"updatetest111", "surname"=>"test", "email"=>"", "password"=>"password");
		$result = $this->userModel->updateUsers($id, $array);
		$this->assertFalse($result);
		
		$id = 50;
		$array = array("name"=>"updatetest111", "surname"=>"test", "email"=>"test@gmail.com", "password"=>"");
		$result = $this->userModel->updateUsers($id, $array);
		$this->assertFalse($result);
	}
	
	public function testSearchUsers()
	{
		$string = "updatetest";
		$search = $this->userModel->searchUsers($string);
		$this->assertTrue($search);
		
		$string = "updatetest2222";
		$search = $this->userModel->searchUsers($string);
		$this->assertFalse($search);
		
		$string = "";
		$search = $this->userModel->searchUsers($string);
		$this->assertFalse($search);
		
		$string = 24;
		$search = $this->userModel->searchUsers($string);
		$this->assertFalse($search);
		
		$string = NULL;
		$search = $this->userModel->searchUsers($string);
		$this->assertFalse($search);
	
	}
	
	
	public function testDeleteuser()
	{
		$array = array("name"=>"test", "surname"=>"test", "email"=>"test@gmail.com", "password"=>"password");
		$result = $this->userModel->createNewUser($array);
		$this->userModel->deleteuser($result);
		$this->assertFalse($this->userModel->getUser($result));
	}
}

?>