<?php

namespace NodeAdmin\Http\Controllers\Admin;

use Illuminate\Support\Str;
use NodeAdmin\Lib\NodeContent\Form;
use NodeAdmin\Lib\NodeContent\Table;
use NodeAdmin\Lib\ResourceController;
use NodeAdmin\Lib\ResourceControllerTrait;
use Opcodes\LogViewer\Facades\LogViewer;
use Opcodes\LogViewer\LogFile;
use Opcodes\LogViewer\Logs\Log;

class LogController extends ResourceController
{
    use ResourceControllerTrait;

    public function table(Table $table)
    {
        $files = LogViewer::getFiles();
        $table->filters(function (Table\FiltersContainer $container) use ($files) {
            $container->select('file', '文件')->setOptions($files->map(function (LogFile $file) {
                return [
                    'label' => $file->name,
                    'value' => $file->name
                ];
            })->toArray());
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
        $table->setFiltersData(['file' => $files->first()->name]);
        return $table;
    }

    public function store(Form $form)
    {
        $form->setOnlyShow(true);
        $form->items(function (Form\ItemsContainer $container){
            $container->input('message', '信息');
            $container->input('level','等级');
            $container->input('datetime', '时间');
            $container->input('stack','堆栈');
        });
        $form->setData(request()->input('content'));
        return $form;
    }

    public function dataList()
    {
        $files = LogViewer::getFiles();
        /** @var LogFile $file */
        $file = $files->first();
        if ($file_index = request()->input('file')) {
            $file = $files->where('name', $file_index)->first();
        }

        $logs = $file->logs();
        if ($search = request()->input('query')) {
            $logs = $logs->search($search);
        }

        $logs = $logs->reverse()->paginate()->through(function (Log $item) {
            $res=[];
            $res['text_short'] = Str::limit($item->message, 60);
            $res['level'] = __($item->level);
            $res['date'] = $item->datetime->format('Y-m-d H:i:s');
            $res['id']=Str::uuid();
            $res['text'] = $item->getOriginalText();
            $res['content'] = [
                'message' => $item->message,
                'level' => $item->level,
                'datetime' => $item->datetime->format('Y-m-d H:i:s'),
                'stack' => $item->getOriginalText(),
            ];
            return $res;
        });

        return $this->transformDataList($logs);
    }
}
