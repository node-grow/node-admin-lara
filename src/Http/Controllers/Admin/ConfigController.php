<?php

namespace NodeAdmin\Http\Controllers\Admin;

use NodeAdmin\Lib\NodeContent\Form;
use NodeAdmin\Lib\NodeContent\NodeResponse;
use NodeAdmin\Lib\NodeContent\Tab;
use NodeAdmin\Lib\ResourceController;
use NodeAdmin\Models\Config;

class ConfigController extends ResourceController
{
    static $TEXT = 'text'; //单行文本
    static $TEXTAREA = 'textarea'; //多行文本
    static $SELECT = 'select'; //选择框
    static $IMAGE = 'image'; //选择框
    static $WANG_EDITOR = 'wang_editor'; //富文本

    protected $upload_url = '';

    protected $config_groups = [
        ['name' => 'default', 'title' => '默认'],
        ['name' => 'other', 'title' => '其它'],
    ];

    public function getConfig(Form $form, Tab $tab, string $group = '')
    {
        if (!$group) {
            $tab->tabs(function (Tab\TabContainer $container) {
                foreach ($this->config_groups as $config_group) {
                    $container->tab_pane($config_group['name'], $config_group['title'], route('admin.sysSetting.index', ['group' => $config_group['name']]));
                }
            });
            return $tab;
        }

        $upload_url = $this->upload_url ?: route('admin.upload');

        $config = Config::query()->where('group', $group)->get()->toArray();
        $data = [];
        $form->items(function (Form\ItemsContainer $container) use ($upload_url, $config, &$data) {
            foreach ($config as $c) {
                $data[$c['name']] = $c['value'];
                switch ($c['type']) {
                    case self::$TEXT:
                        $container->input($c['name'], $c['title'], $c['tips']);
                        break;
                    case self::$TEXTAREA:
                        $container->textarea($c['name'], $c['title'], $c['tips']);
                        break;
                    case self::$IMAGE:
                        $data[$c['name']] = getFilesValueByIds($c['value']);
                        $container->image_upload($c['name'], $c['title'], $c['tips'])
                            ->setConfigUrl($upload_url)
                            ->setMaxCount(1);
                        break;
                    case self::$SELECT:
                        $container->select($c['name'], $c['title'], $c['tips'])->setOptions(json_decode($c['option'], true));
                        break;
                    case self::$WANG_EDITOR:
                        $container->wang_editor($c['name'], $c['title'], $c['tips'])->setUploadConfigUrl($upload_url);
                        break;
                    default:
                        break;
                }
            }
        });
        $form->actions(function (Form\ActionsContainer $container) use ($group) {
            $container->submit('保存')->request(action([get_class($this), 'update'], ['group' => $group]), 'post');
        });

        $form->setData($data);

        return $form;
    }

    public function update($group = 'default')
    {
        $query = Config::query();
        if ($group) {
            $query->where('group', $group);
        }
        $data = $query->get()->toArray();

        \DB::transaction(function () use ($data) {
            foreach ($data as $d) {
                $value = \request()->input($d['name']);
                $value = $this->transformValue($d, $value);
                Config::query()->where('name', $d['name'])->update(['value' => $value]);
            }
        });

        return new NodeResponse('', '保存成功');

    }

    protected function transformValue($item, $value)
    {
        switch ($item['type']) {
            case self::$IMAGE:
                if ($value) {
                    $id = array_column($value, 'id');
                    $value = implode(',', $id);
                }
                break;
        }

        return $value;
    }


    public function getOneConfig(string $name = 'SITE_NAME')
    {
        $config = Config::query()->where('name', $name)->first();
        $default_tab = config('admin.default_tabs');
        return [
            'system_name' => $config['value'],
            'iconfont_url' => \config('admin.iconfont_symbol_url'),
            'default_tabs' => $default_tab,

            'extra_scripts' => [
                asset('components/test-component.umd.js')
            ]
        ];
    }
}
