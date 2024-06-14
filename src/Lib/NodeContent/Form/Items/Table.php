<?php

namespace NodeAdmin\Lib\NodeContent\Form\Items;


use NodeAdmin\Lib\NodeContent\Form\Items\Table\ColumnsContainer;

class Table extends BaseItem
{
    protected $columns;

    public function __construct($name, $label = '', $tips = '')
    {
        parent::__construct($name, $label, $tips);

        $this->columns = app()->make(ColumnsContainer::class);
    }

    public function columns(\Closure $cb)
    {
        $cb($this->columns);
    }

    public function setData(array $data): Table
    {
        $this->data = $data;
        return $this;
    }

    public function toArray(): array
    {
        $this->render_data['item_option']['columns'] = $this->columns;
        return parent::toArray();
    }
}
