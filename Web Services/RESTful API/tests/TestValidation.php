<?php
/*
 * @version 1.0.0
 * @author Ben Creasey <ben.creasey@mydit.ie>
 */
require_once ('../simpletest/autorun.php');
class TestValidation extends UnitTestCase
{
	public function setUp()
	{
		require_once ('../app/models/Validation.php');
		$this->validation = new Validation();
	}
	
	public function tearDown()
	{
		$this->validation = NULL ;
	}
	
	public function testIsEmailValid()
	{
		//Acceptable
		$this->assertTrue($this->validation->isEmailValid("test@test.com"));
		$this->assertTrue($this->validation->isEmailValid("test_test@test.com"));
		$this->assertTrue($this->validation->isEmailValid("test.test@test.com"));
		$this->assertTrue($this->validation->isEmailValid("test@student.test.com"));
		//Unacceptable
		$this->assertFalse($this->validation->isEmailValid(" "));
		$this->assertFalse($this->validation->isEmailValid(" test@test.com "));
		$this->assertFalse($this->validation->isEmailValid("test.test.com"));
		$this->assertFalse($this->validation->isEmailValid("test@test-com"));
		$this->assertFalse($this->validation->isEmailValid("test@test@test.com"));
		$this->assertFalse($this->validation->isEmailValid(12));
		$this->assertFalse($this->validation->isEmailValid(TRUE));
	}
	
	public function testIsNumberInRangeValid()
	{
		//Acceptable
		$this->assertTrue($this->validation->isNumberInRangeValid(5, 1, 10));
		$this->assertTrue($this->validation->isNumberInRangeValid(10.5, 3.8, 13.9));
		//Unacceptable
		$this->assertFalse($this->validation->isNumberInRangeValid(" ", " ", " "));
		$this->assertFalse($this->validation->isNumberInRangeValid(3, 5, 10));
		$this->assertFalse($this->validation->isNumberInRangeValid(3, 5, 1));
		$this->assertFalse($this->validation->isNumberInRangeValid(TRUE, 3, 20));
	}
	
	public function testIsLengthStringValid()
	{
		//Acceptable
		$this->assertTrue($this->validation->isLengthStringValid("string", 6));
		$this->assertTrue($this->validation->isLengthStringValid("to", 2));
		$this->assertTrue($this->validation->isLengthStringValid("nine", 9));
		//Unacceptable
		$this->assertFalse($this->validation->isLengthStringValid(1, " "));
		$this->assertFalse($this->validation->isLengthStringValid(1, "one"));
		$this->assertFalse($this->validation->isLengthStringValid(1, "p"));
		$this->assertFalse($this->validation->isLengthStringValid(1, "one"));
		$this->assertFalse($this->validation->isLengthStringValid("two", 2));
		$this->assertFalse($this->validation->isLengthStringValid(array("one", "little", "array"), 2));
		$this->assertFalse($this->validation->isLengthStringValid(TRUE, 3));
	}
}

?>