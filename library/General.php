<?php
namespace library;

class General
{
	function getTitle(&$ctrl, $title)
	{
		$layout = $ctrl->getProperty('layout');
		$layout['title'] = $title;
		$ctrl->addConfig(['layout' => $layout]);
	}
}
?>