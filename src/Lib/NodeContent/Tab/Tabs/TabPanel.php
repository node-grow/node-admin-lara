<?php

namespace NodeAdmin\Lib\NodeContent\Tab\Tabs;

use NodeAdmin\Lib\NodeContent\Traits\PreloadNodeData;

class TabPanel extends BaseTab
{
    use PreloadNodeData;

    protected $render_data = [
        'name' => '',
        'title' => '',
        'url' => '',
        'method' => '',
    ];

    public function __construct(string $name, string $title, string $url, string $method = 'get')
    {
        $this->render_data['name'] = $name;
        $this->render_data['title'] = $title;
        $this->render_data['url'] = $url;
        $this->render_data['method'] = $method;
    }

    protected function setNodeDataToRender()
    {
        $this->render_data['node_data'] = $this->node_data;
    }
}
