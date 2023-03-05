<?php

namespace NodeAdmin\Lib\NodeContent\Form\Items;

class WangEditor extends BaseItem
{

    public function setUploadConfigUrl($url)
    {
        $this->render_data['item_option']['upload_image_config_url'] = $url;
        return $this;
    }

}
