<?php

namespace NodeAdmin\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use NodeAdmin\Exceptions\NodeException;
use NodeAdmin\Models\AdminPermission;

class AdminPermissionService
{
    protected function getRules(){
        return [
            'name'=>'required',
            'path'=>'required',
        ];
    }

    protected function getAttributes(){
        return [
            'name'=>'权限点名称',
            'description'=>'描述',
            'path'=>'权限点路径',
        ];
    }

    public function create(Request $request){
        Validator::validate($request->input(),$this->getRules(),[],$this->getAttributes());
        $permission=new AdminPermission();
        foreach ($request->input() as $k=>$v) {
            $permission->$k=$v;
        }
        $r=$permission->save();
        if ($r===false){
            throw new NodeException('保存失败');
        }
    }
    public function update(Request $request,AdminPermission $permission){
        Validator::validate($request->input(),$this->getRules(),[],$this->getAttributes());
        foreach ($request->input() as $k=>$v) {
            $permission->$k=$v;
        }
        $r=$permission->save();
        if ($r===false){
            throw new NodeException('保存失败');
        }
    }
}
