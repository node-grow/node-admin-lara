<?php

namespace NodeAdmin\Lib\NodeContent\Traits;

use NodeAdmin\Lib\NodeContent\BaseContent;

trait PreloadNodeData
{
    protected BaseContent $node_data;

    public function setNodeData(BaseContent $node_data)
    {
        $this->node_data = $node_data;
        $this->setNodeDataToRender();
        return $this;
    }

    abstract protected function setNodeDataToRender();
}
