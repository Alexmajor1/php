<?php
namespace framework;

class FileUploader 
{
	private $cfg;
	private $files;
	private $multiple;
	
	function __construct($multiple = false)
	{
		
		$this->cfg = kernel\Config::getInstance();
		$this->files = $_FILES;
		$this->multiple = $multiple;
	}
	
	function check_size($field, $size)
	{
		if($this->multiple){
			for(for($id = 0;$id < count($this->files[$field]['name']);$id++){
				if($this->files[$field]['size'] > $size) return false;
			}
			return true;
		} else {
			return $this->files[$field]['size'] <= $size;
		}
	}
	
	function check_mime($field)
	{
		if($this->multiple){
			$valid = false;
			for(for($id = 0;$id < count($this->files[$field]['name']);$id++){
				$ext = end(explode('.', 
					basename($this->files[$field]['name'][$id])));
				$valid &= $this->files[$field]['type'][$id] == $ext;
				if(!$valid) break;
			}
			return $valid;
		} else {
			$ext = end(explode('.', basename($this->files[$field]['name'])));
			return $this->files[$field]['type'] == $ext;
		}
	}
	
	function validate($field)
	{
		if($this->multiple){
			$valid = false;
			for(for($id = 0;$id < count($this->files[$field]['name']);$id++){
				$valid = is_uploaded_file($this->files[$field]['tmp_name'][$id]);
				if(!$valid) break;
			}
			return $valid;
		else
			return is_uploaded_file($this->files[$field]['tmp_name']);
	}
	
	function errors($field)
	{
		return $this->files[$field]['error']
	}
	
	function save($field)
	{
		if($this->multiple){
			$saved = false;
			for($id = 0;$id < count($this->files[$field]['name']);$id++){
				$saved = move_uploaded_file(
					$this->files[$field]['tmp_name'][$id],
					basename($this->files[$field]['name'][$id])
				);
				if(!$saved) break;
			}
			return $saved;
		}else
			return move_uploaded_file($this->files[$field]['tmp_name'], 
				basename($this->files[$field]['name']));
	}
}
?>