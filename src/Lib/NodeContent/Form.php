<?php

namespace NodeAdmin\Lib\NodeContent;

use NodeAdmin\Lib\NodeContent\Form\ActionsContainer;
use NodeAdmin\Lib\NodeContent\Form\ItemsContainer;

class Form extends BaseContent
{
    protected $only_show=false;
    protected $actions;
    protected $items;
    protected $data=[];

    protected $render_data=[
        'type'=>'form',
        'option'=>[
            'items'=>'',
            'data'=>[],
            'actions'=>'',
        ]
    ];

    public function __construct(ActionsContainer $actions,ItemsContainer $items)
    {
        $this->actions=$actions;
        $this->items=$items;
    }

    public function setOnlyShow(bool $only_show){
        $this->only_show=$only_show;
    }

    public function actions(\Closure $fn){
        $fn($this->actions);
    }

    public function items(\Closure $fn){
        $fn($this->items);
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function toArray(): array
    {
        $this->render_data['option']['actions']=$this->actions;
        if ($this->only_show){
            $items=$this->items->getItems();
            foreach ($items as $item) {
                if (method_exists($item,'transformOnlyShow')){
                    $item->transformOnlyShow($this->data);
                }
            }
        }
        $this->render_data['option']['items']=$this->items;
        $this->render_data['option']['data']=$this->data;
        return parent::toArray();
    }

}
