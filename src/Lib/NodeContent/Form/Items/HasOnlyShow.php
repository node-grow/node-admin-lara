<?php

namespace NodeAdmin\Lib\NodeContent\Form\Items;

trait HasOnlyShow
{
    abstract public function transformOnlyShow($form_data);
}
