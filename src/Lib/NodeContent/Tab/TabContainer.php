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

    public function tab_pane(...$params)
    {
        $this->render_data[] = new TabPanel(...$params);
    }
}
