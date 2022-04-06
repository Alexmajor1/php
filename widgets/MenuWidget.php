<?php
namespace widgets;

use framework\Widget;

class MenuWidget extends Widget
{
	public function execute($cfg)
	{
		$this->cfg = $this->cfg[$cfg->getSetting('site_template')];
	}
}
?>