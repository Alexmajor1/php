<?php

use models\User;
use models\Registration;

use framework\Application;
use framework\Request;
use framework\Validator;

class SmokeUnitTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
	protected $app;
    
    protected function _before()
    {
		$this->app = new Application("config".DIRECTORY_SEPARATOR."settings.php");
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
		$user = (new User())->read(['User_name'], ['id' => 2]);
		$this->assertTrue($user->User_name == 'programer');
		
		$req = new Request();
		$this->assertTrue($req->get() == []);
		$this->assertTrue($req->post() == []);
		$this->assertTrue($req->cookie() == []);
		
		$reg = new Registration([
			'login' => 'programer',
			'password' => 'Lordyargut1',
			'role' => 'Customer'
		]);
		$this->assertTrue(is_object($reg->CheckUser()));
		$this->assertTrue($reg->CheckPassword() == 'ok');
		$this->assertTrue(!$reg->validate([
			'login' => 'programer',
			'password' => 'Lordyargut1',
			'role' => 'Customer'
		]));
		
		$validator = new Validator([
			'number' => 1,
			'string' => 'rasgar@inbox.ru',
			'empty' => '',
			'query' => 'select * from users',
		]);
		$this->assertTrue($validator->numeric('number'));
		$this->assertTrue($validator->row('string'));
		$this->assertTrue($validator->lenght('string', 10));
		$this->assertTrue($validator->numeric('number'));
		$this->assertTrue($validator->content('string', 'alpha'));
		$this->assertTrue($validator->void('empty'));
		$this->assertTrue($validator->sql('query'));
		$this->assertTrue($validator->email('string'));
    }
}