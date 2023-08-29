<?php

namespace NodeAdmin\Lib\NodeContent\Operation;

use NodeAdmin\Lib\NodeContent\BaseContent;

abstract class BaseOperation extends BaseContent
{
    protected $render_data = [
        'type' => '',
        'reload_layout' => false,
        'operation_option' => [],
    ];

    /**
     * @param bool $reload
     * @return $this
     */
    public function setReloadLayout(bool $reload)
    {
        $this->render_data['reload_layout'] = $reload;
        return $this;
    }
}
