<?php

namespace NodeAdmin\Lib\NodeContent\Table;

use NodeAdmin\Lib\NodeContent\Container;
use NodeAdmin\Lib\NodeContent\Table\Filters\BaseFilter;
use NodeAdmin\Lib\NodeContent\Table\Filters\Custom;
use NodeAdmin\Lib\NodeContent\Table\Filters\Date;
use NodeAdmin\Lib\NodeContent\Table\Filters\DateRange;
use NodeAdmin\Lib\NodeContent\Table\Filters\Input;
use NodeAdmin\Lib\NodeContent\Table\Filters\Select;

/**
 * @method Input input($name, $title=null)
 * @method Select select($name,$title='')
 * @method Custom custom($name,$title='')
 * @method Date date($name,$title='')
 * @method DateRange date_range($name,$title='')
 */
class FiltersContainer extends Container
{

    protected $render_data=[];

    public function addFilter(BaseFilter $filter){
        $this->render_data[]=$filter;
    }

    protected function getAutoCallNamespace()
    {
        return 'NodeAdmin\Lib\NodeContent\Table\Filters';
    }

    protected function getAutoCallMethod()
    {
        return 'addFilter';
    }
}
