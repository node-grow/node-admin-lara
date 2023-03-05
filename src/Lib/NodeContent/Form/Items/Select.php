<?php

namespace NodeAdmin\Lib\NodeContent\Form\Items;

use NodeAdmin\Lib\NodeContent\Traits\HasOptions;

class Select extends BaseItem
{
    use HasOptions;

    public function setPlaceholder($placeholder){
        $this->render_data['item_option']['placeholder'] = $placeholder;
        return $this;
    }

    protected function getOptionName():string{
        return 'item_option';
    }

    /**
     * 设置可搜索
     * @param bool $searchable
     * @return $this
     */
    public function setSearchable(bool $searchable){
        $this->render_data['item_option']['searchable']=$searchable;
        return $this;
    }

    /**
     * 设置搜索的uri
     * @param string $url
     * @return $this
     */
    public function setSearchUrl(string $url){
        $this->setSearchable(true);
        $this->render_data['item_option']['search_url']=$url;
        return $this;
    }

    /**
     * 设置展示模式
     * @param string $mode 取值 combobox|tags|multiple
     * @return $this
     */
    public function setMode(string $mode){
        $this->render_data['item_option']['mode']=$mode;
        return $this;
    }

}
