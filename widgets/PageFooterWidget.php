<?php
namespace widgets;

use framework\Widget;

class PageFooterWidget extends Widget
{
	public function execute($cfg)
	{
		$this->loadContent($cfg);
	}
}
?>