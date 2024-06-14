<?php

namespace NodeAdmin\Lib\NodeContent\Form\Items\Table\Column;

class Input extends BaseColumn
{
    public function setPlaceholder(string $placeholder)
    {
        $this->render_data['column_option']['placeholder'] = $placeholder;
        return $this;
    }
}
