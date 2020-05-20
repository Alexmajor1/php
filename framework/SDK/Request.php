<?php
namespace framework;

class Request
{
	private $post;
	private $get;
	private $cookie;
	
	function __construct()
	{
		$this->post = $_POST;
		$this->get = $_GET;
		$this->cookie = $_COOKIE;
	}
	
	function get($key = '')
	{
		if($key == '')
			return $this->get;
		else if(key_exists($key, $this->get))
			return $this->get[$key];
		else return false;
	}
	
	function post($key = '')
	{
		if($key == '')
			return $this->post;
		else if(key_exists($key, $this->post))
			return $this->post[$key];
		else return false;
	}
	
	function cookie($key = '')
	{
		if($key == '')
			return $this->cookie;
		else if(key_exists($key, $this->cookie))
			return $this->cookie[$key];
		else return false;
	}
	
	function getCurrentUrl()
	{
		return $_SERVER['REQUEST_URI'];
	}
}
?>