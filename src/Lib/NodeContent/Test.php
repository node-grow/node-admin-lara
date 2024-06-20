<?php

namespace NodeAdmin\Lib\NodeContent;

class Test extends BaseContent
{

    protected $render_data = [
        'type' => 'test',
        'option' => [
            'title' => 'test props'
        ]
    ];

    public function __construct()
    {

    }
}
