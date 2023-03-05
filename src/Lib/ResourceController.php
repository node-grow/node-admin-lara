<?php

namespace NodeAdmin\Lib;

use Illuminate\Routing\Controller;

/**
 * @method index() 数据列表渲染接口
 * @method show() 获取单条数据接口
 * @method create() 新增页渲染
 * @method store() 新增action
 * @method edit() 编辑页渲染
 * @method update() 保存
 * @method destroy() 删除
 *
 * @method forbid() 禁用
 * @method resume() 启用
 */
abstract class ResourceController extends Controller
{

}
