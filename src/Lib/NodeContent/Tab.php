<?php

namespace NodeAdmin\Lib\NodeContent;

use NodeAdmin\Exceptions\NodeException;
use NodeAdmin\Lib\NodeContent\Tab\TabContainer;

class Tab extends BaseContent
{
    protected TabContainer $tabs;

    protected $render_data = [
        'type' => 'tab',
        'option' => [
            'tabs' => [],
            'default_tab' => '',
        ]
    ];

    public function __construct(TabContainer $tabs)
    {
        $this->tabs = $tabs;
    }

    public function tabs(\Closure $fn)
    {
        $fn($this->tabs);
    }

    public function setDefaultTab(string $name)
    {
        $this->render_data['default_tab'] = $name;
    }

    public function toArray(): array
    {
        $tabs = $this->tabs->toArray();
        if (!$tabs) {
            throw new NodeException('No tabs');
        }
        $this->render_data['option']['tabs'] = $this->tabs;
        if (!$this->render_data['option']['default_tab']) {
            $this->render_data['option']['default_tab'] = $tabs[0]['name'];
        }
        return parent::toArray();
    }
}
