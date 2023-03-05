<?php

namespace NodeAdmin\Lib\NodeContent\Form\Items;

class ImageUpload extends BaseItem
{

    public function setMaxCount($max_count){
        $this->render_data['item_option']['max_count'] = $max_count;
        return $this;
    }

    public function setConfigUrl(String $config_url){
        $this->render_data['item_option']['config_url'] = $config_url;
        return $this;
    }

}
