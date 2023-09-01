<?php

namespace NodeAdmin\Http\Controllers\Admin;

use NodeAdmin\Lib\NodeContent\Form;
use NodeAdmin\Lib\NodeContent\NodeResponse;
use NodeAdmin\Lib\NodeContent\Tab;
use NodeAdmin\Lib\ResourceController;
use NodeAdmin\Models\Config;
use NodeAdmin\Models\Files;

class ConfigController extends ResourceController
{
    static $TEXT = 'text'; //单行文本
    static $TEXTAREA = 'textarea'; //多行文本
    static $SELECT = 'select'; //选择框
    static $IMAGE = 'image'; //选择框
    static $WANG_EDITOR = 'wang_editor'; //富文本

    protected $upload_url = '';

    public function getConfig(Form $form, Tab $tab, string $group = '')
    {
        if (!$group) {
            $tab->tabs(function (Tab\TabContainer $container) {
                $container->tab_pane('default', '默认', route('admin.sysSetting.index', ['group' => 'default']));
                $container->tab_pane('other', '其它', route('admin.sysSetting.index', ['group' => 'other']));
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
                        $data[$c['name']] = [];
                        foreach (explode(',', $c['value']) as $fid) {
                            $data[$c['name']][] = [
                                'id' => $fid,
                                'url' => Files::query()->where('id', $fid)->value('url'),
                            ];
                        }
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
        $form->actions(function (Form\ActionsContainer $container) {
            $container->submit('保存')->request(action([get_class($this), 'update']), 'post');
        });

        $form->setData($data);

        return $form;
    }

    public function update(Config $config)
    {
        $data = $config->query()->get()->toArray();

        foreach ($data as $d) {
            $value = \request()->input($d['name']);
            if ($d['type'] == self::$IMAGE) {
                $id = array_column($value,'id');
                $value = implode(',',$id);
            }
            $config->query()->where('name', $d['name'])->update(['value' => $value]);
        }

        return new NodeResponse('', '保存成功');

    }


    public function getOneConfig(string $name = 'SITE_NAME')
    {
        $config = Config::query()->where('name', $name)->first();
        $default_tab = config('admin.default_tabs');
        return [
            'system_name' => $config['value'],
            'iconfont_url' => \config('admin.iconfont_symbol_url'),
            'default_tabs' => $default_tab
        ];
    }
}
