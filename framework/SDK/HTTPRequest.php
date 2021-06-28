<?php
namespace framework;

class HTTPRequest
{
	var $ch;
	
	function __construct($url, $options)
	{
		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_URL, $url);
		
		foreach($options as $name => $value)
			curl_setopt($this->ch, $name, $value);
	}
	
	function setOption($name, $value)
	{
		curl_setopt($this->ch, $name, $value);
	}
	
	function getString()
	{
		return curl_exec($this->ch);
	}
	
	function getJson()
	{
		return json_decode(curl_exec($this->ch), true);
	}
	
	function close()
	{
		curl_close($this->ch);
	}
}
?>