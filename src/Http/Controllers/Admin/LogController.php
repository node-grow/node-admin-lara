<?php

namespace NodeAdmin\Http\Controllers\Admin;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use NodeAdmin\Lib\NodeContent\Form;
use NodeAdmin\Lib\NodeContent\Table;
use NodeAdmin\Lib\ResourceController;
use NodeAdmin\Lib\ResourceControllerTrait;
use Rap2hpoutre\LaravelLogViewer\LaravelLogViewer;

class LogController extends ResourceController
{
    use ResourceControllerTrait;

    public function table(Table $table)
    {
        $log_viewer=new LaravelLogViewer();
        $files=$log_viewer->getFiles(true);
        $table->filters(function (Table\FiltersContainer $container) use ($files) {
            $container->select('file_index','文件')->setOptions($files);
            $container->input('text','信息');
        });
        $table->columns(function (Table\ColumnsContainer $container){
            $container->text('date','时间');
            $container->text('level','等级');
            $container->text('text_short','信息');
            $container->actions('','操作')->setActions(function (Table\Columns\Actions\ActionsContainer $container){
                $container->linkButton()->setTitle('查看')
                    ->modal(action([get_class($this),'store']),'查看详情')
                    ->setBody([
                        'content'=>'__content__'
                    ])
                    ->setMethod('post');
            });
        });
        $table->setFiltersData(['file_index'=>0]);
        return $table;
    }

    public function store(Form $form)
    {
        $form->setOnlyShow(true);
        $form->items(function (Form\ItemsContainer $container){
            $container->input('text','信息');
            $container->input('level','等级');
            $container->input('date','时间');
            $container->input('stack','堆栈');
        });
        $content=json_decode(request()->input('content'),true);
        $form->setData($content);
        return $form;
    }

    public function dataList()
    {
        $log_viewer=new LaravelLogViewer();
        $files=$log_viewer->getFiles(true);
        $file=$files[0];
        if ($file_index=request()->input('file_index')){
            $file=$files[$file_index];
        }
        $log_viewer->setFile($file);

        $logs = $log_viewer->all();
        if ($search=request()->input('text')){
            $logs=collect($logs)->filter(function ($item) use ($search){
                return Str::contains($item['text'],$search);
            })->values();
        }

        $logs=collect($logs)->map(function ($item){
            $res=[];
            $res['text_short']=Str::limit($item['text'],60);
            $res['level']=__($item['level']);
            $res['content']=json_encode($item);
            $res['date']=$item['date'];
            $res['id']=Str::uuid();
            return $res;
        });

        $page=new LengthAwarePaginator($logs,$logs->count(),10);
        return $this->transformDataList($page);
    }
}
