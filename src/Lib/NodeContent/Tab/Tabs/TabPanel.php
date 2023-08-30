<?php

namespace NodeAdmin\Lib\NodeContent\Tab\Tabs;

class TabPanel extends BaseTab
{
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
}
