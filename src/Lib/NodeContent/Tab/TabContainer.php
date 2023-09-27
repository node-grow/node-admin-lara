<?php

namespace NodeAdmin\Lib\NodeContent\Tab;

use NodeAdmin\Lib\NodeContent\BaseContent;
use NodeAdmin\Lib\NodeContent\Tab\Tabs\TabPanel;

/**
 * @method
 */
class TabContainer extends BaseContent
{
    protected $render_data = [];

    public function tab_pane(string $name, string $title, string $url, string $method = 'get')
    {
        $panel = new TabPanel($name, $title, $url, $method);
        $this->render_data[] = $panel;
        return $panel;
    }
}
