<?php
namespace Controllers;

use framework\Controller;
use framework\Request;

class EditorController extends Controller
{
	public $rules = ['Admin', 'Editor'];
	public $widgets = ['Menu', 'PageFooter'];
	
	function index()
	{
		$req = new Request();
		$data = $req->post();
		
		if(isset($data['User']) && isset($data['Password'])) {
			if($data['User'] == 'editor' && $data['Password'] = 'editor')
				$this->toPage('editor\\\\migrations');
			else{
				$this->getError('wrong login or password');
				$this->toPage('editor\\\\main');
			}
		}
	}
	
	function migrations()
	{
		$CLI = (PHP_OS == 'WINNT')? 'c:\xampp\php\php.exe ' : 'php ';
		$req = new Request();
		$data = $req->post();
		
		if(isset($data['Name'])){
			$out = null;
			$res = null;
			exec($CLI.__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'$CLI.php migrate create '.$data['Name'], $out, $res);
		}
	}
	
	function controllers()
	{
		$CLI = (PHP_OS == 'WINNT')? 'c:\xampp\php\php.exe ' : 'php ';
		$req = new Request();
		$data = $req->post();
		
		if(isset($data['Name']) && isset($data['Pages'])){
			$out = null;
			$res = null;
			exec($CLI.__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'$CLI.php controller create '.$data['Name'].' '.$data['Pages'], $out, $res);
		}
	}
	
	function rules()
	{
		$CLI = (PHP_OS == 'WINNT')? 'c:\xampp\php\php.exe ' : 'php ';
		$req = new Request();
		$data = $req->post();
		
		if(isset($data['Name'])){
			$out = null;
			$res = null;
			exec($CLI.__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'$CLI.php rule create '.$data['Name'], $out, $res);
		}
	}
	
	function models()
	{
		$CLI = (PHP_OS == 'WINNT')? 'c:\xampp\php\php.exe ' : 'php ';
		$req = new Request();
		$data = $req->post();
		
		if(isset($data['Name']) && isset($data['Fields'])){
			$out = null;
			$res = null;
			exec($CLI.__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'$CLI.php model create '.$data['Name'].' '.$data['Fields'], $out, $res);
		}
	}
	
	function templates()
	{
		$CLI = (PHP_OS == 'WINNT')? 'c:\xampp\php\php.exe ' : 'php ';
		$req = new Request();
		$data = $req->post();
		
		if(isset($data['Name']) && isset($data['Pages'])){
			$out = null;
			$res = null;
			exec($CLI.__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'$CLI.php template create '.$data['Name'].' '.$data['Pages'], $out, $res);
		}
	}
	
	function plugins()
	{
		$CLI = (PHP_OS == 'WINNT')? 'c:\xampp\php\php.exe ' : 'php ';
		$req = new Request();
		$data = $req->post();
		
		if(isset($data['Name'])){
			$out = null;
			$res = null;
			exec($CLI.__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'$CLI.php plugin create '.$data['Name'], $out, $res);
		}
	}
	
	function widgets()
	{
		$CLI = (PHP_OS == 'WINNT')? 'c:\xampp\php\php.exe ' : 'php ';
		$req = new Request();
		$data = $req->post();
		
		if(isset($data['Name'])){
			$out = null;
			$res = null;
			exec($CLI.__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'$CLI.php widget create '.$data['Name'], $out, $res);
		}
	}
}
?>