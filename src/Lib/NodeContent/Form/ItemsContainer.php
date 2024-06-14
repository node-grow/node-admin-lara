<?php

namespace NodeAdmin\Lib\NodeContent\Form;

use NodeAdmin\Lib\NodeContent\Container;
use NodeAdmin\Lib\NodeContent\Form\Items\BaseItem;
use NodeAdmin\Lib\NodeContent\Form\Items\Checkbox;
use NodeAdmin\Lib\NodeContent\Form\Items\Custom;
use NodeAdmin\Lib\NodeContent\Form\Items\Date;
use NodeAdmin\Lib\NodeContent\Form\Items\DateRange;
use NodeAdmin\Lib\NodeContent\Form\Items\Division;
use NodeAdmin\Lib\NodeContent\Form\Items\FileUpload;
use NodeAdmin\Lib\NodeContent\Form\Items\Iconfont;
use NodeAdmin\Lib\NodeContent\Form\Items\ImageUpload;
use NodeAdmin\Lib\NodeContent\Form\Items\Input;
use NodeAdmin\Lib\NodeContent\Form\Items\Password;
use NodeAdmin\Lib\NodeContent\Form\Items\Radio;
use NodeAdmin\Lib\NodeContent\Form\Items\Select;
use NodeAdmin\Lib\NodeContent\Form\Items\SwitchCase;
use NodeAdmin\Lib\NodeContent\Form\Items\Table;
use NodeAdmin\Lib\NodeContent\Form\Items\Text;
use NodeAdmin\Lib\NodeContent\Form\Items\Textarea;
use NodeAdmin\Lib\NodeContent\Form\Items\WangEditor;

/**
 * @method Text text($name, $label = null, $tips = '')
 * @method Input input($name, $label = null, $tips = '')
 * @method Textarea textarea($name, $label = null, $tips = '')
 * @method ImageUpload image_upload($name, $label, $tips = '')
 * @method Select select($name, $label = null, $tips = '')
 * @method Checkbox checkbox($name, $label, $tips = '')
 * @method Radio radio($name, $label = null, $tips = '')
 * @method Password password($name, $label = null, $tips = '')
 * @method Date date($name, $label = null, $tips = '')
 * @method DateRange date_range($name, $label = null, $tips = '')
 * @method SwitchCase switch_case($name, $label = null, $tips = '')
 * @method WangEditor wang_editor($name, $label = null, $tips = '')
 * @method Iconfont iconfont($name, $label = null, $tips = '')
 * @method Custom custom($name, $label = null, $tips = '')
 * @method Division division($name, $label = null, $tips = '')
 * @method FileUpload file_upload($name, $label = null, $tips = '')
 * @method Table table($name, $label = null, $tips = '')
 */
class ItemsContainer extends Container
{

    protected $render_data = [];

    public function addItem(BaseItem $item)
    {
        $this->render_data[] = $item;
    }

    public function getItems()
    {
        return $this->render_data;
    }

    protected function getAutoCallNamespace()
    {
        return 'NodeAdmin\Lib\NodeContent\Form\Items';
    }

    protected function getAutoCallMethod()
    {
        return 'addItem';
    }
}
