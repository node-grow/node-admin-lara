<?php

namespace NodeAdmin\Lib\NodeContent;

use NodeAdmin\Lib\NodeContent\Table\ActionsContainer;
use NodeAdmin\Lib\NodeContent\Table\Columns\Selection;
use NodeAdmin\Lib\NodeContent\Table\ColumnsContainer;
use NodeAdmin\Lib\NodeContent\Table\FiltersContainer;

class Table extends BaseContent
{
    protected $actions;
    protected $filters;
    protected $columns;
    protected $data_url='';
    protected $data_key='id';
    protected $has_selection=true;
    protected $filters_data;

    protected $render_data=[
        'type'=>'table',
        'option'=>[
            'data_url'=>'',
            'data_key'=>'',
        ]
    ];

    public function __construct(ActionsContainer $actions,FiltersContainer $filters,ColumnsContainer $columns)
    {
        $this->actions=$actions;
        $this->filters=$filters;
        $this->columns=$columns;
        $this->filters_data=(object)[];
    }

    public function actions(\Closure $fn){
        $fn($this->actions);
    }

    public function filters(\Closure $fn){
        $fn($this->filters);
    }

    public function columns(\Closure $fn){
        $fn($this->columns);
    }

    /**
     * @param string $data_url
     */
    public function setDataUrl(string $data_url): void
    {
        $this->data_url = $data_url;
    }

    /**
     * @param string $data_key
     */
    public function setDataKey(string $data_key): void
    {
        $this->data_key = $data_key;
    }

    /**
     * @return string
     */
    public function getDataUrl(): string
    {
        return $this->data_url;
    }

    /**
     * @param bool $has_selection
     */
    public function setHasSelection(bool $has_selection)
    {
        $this->has_selection = $has_selection;
    }

    public function toArray(): array
    {
        $this->render_data['option']['actions']=$this->actions;
        $this->render_data['option']['filters']=$this->filters;
        $this->render_data['option']['columns']=$this->columns;
        if ($this->has_selection){
            $this->columns->addColumn(new Selection('',''));
        }
        $this->render_data['option']['data_url']=$this->data_url;
        $this->render_data['option']['data_key']=$this->data_key;
        $this->render_data['option']['filters_data']=$this->filters_data;
        return parent::toArray();
    }

    /**
     * @param array $filter_data
     * @return $this
     */
    public function setFiltersData(array $filter_data)
    {
        $this->filters_data = (object)$filter_data;
        return $this;
    }

}
