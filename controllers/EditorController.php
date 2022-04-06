<?php
namespace Controllers;

use framework\Controller;
use framework\Request;

class EditorController extends Controller
{
	public $rules = ['Editor'];
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
		$req = new Request();
		$data = $req->post();
		
		if(isset($data['Name'])){
			$out = null;
			$res = null;
			exec('c:\xampp\php\php.exe '.__DIR__.'\\..\\cli.php migrate create '.$data['Name'], $out, $res);
		}
	}
	
	function controllers()
	{
		$req = new Request();
		$data = $req->post();
		
		if(isset($data['Name']) && isset($data['Pages'])){
			$out = null;
			$res = null;
			exec('c:\xampp\php\php.exe '.__DIR__.'\\..\\cli.php controller create '.$data['Name'].' '.$data['Pages'], $out, $res);
		}
	}
	
	function rules()
	{
		$req = new Request();
		$data = $req->post();
		
		if(isset($data['Name'])){
			$out = null;
			$res = null;
			exec('c:\xampp\php\php.exe '.__DIR__.'\\..\\cli.php rule create '.$data['Name'], $out, $res);
		}
	}
	
	function models()
	{
		$req = new Request();
		$data = $req->post();
		
		if(isset($data['Name']) && isset($data['Fields'])){
			$out = null;
			$res = null;
			exec('c:\xampp\php\php.exe '.__DIR__.'\\..\\cli.php model create '.$data['Name'].' '.$data['Fields'], $out, $res);
		}
	}
	
	function templates()
	{
		$req = new Request();
		$data = $req->post();
		
		if(isset($data['Name']) && isset($data['Pages'])){
			$out = null;
			$res = null;
			exec('c:\xampp\php\php.exe '.__DIR__.'\\..\\cli.php template create '.$data['Name'].' '.$data['Pages'], $out, $res);
		}
	}
	
	function plugins()
	{
		$req = new Request();
		$data = $req->post();
		
		if(isset($data['Name'])){
			$out = null;
			$res = null;
			exec('c:\xampp\php\php.exe '.__DIR__.'\\..\\cli.php plugin create '.$data['Name'], $out, $res);
		}
	}
	
	function widgets()
	{
		$req = new Request();
		$data = $req->post();
		
		if(isset($data['Name'])){
			$out = null;
			$res = null;
			exec('c:\xampp\php\php.exe '.__DIR__.'\\..\\cli.php widget create '.$data['Name'], $out, $res);
		}
	}
}
?>