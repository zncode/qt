<?php
namespace app\admin\controller;

use app\admin\controller\BaseController;
use think\Db;

class ChannelController extends BaseController
{
    public $pager = 20;
    public $table = 'qt_channel';
    public $url_path = 'channel';
    public $module_name = '频道';

    /**
     * 列表
     */
    public function index()
    {
        $pages  = Db::table($this->table)->where(array('delete'=>0))->order('create_time desc')->paginate($this->pager);
        $render = $pages->render();
        $lists  = $pages->all();

        $data['list']           = $lists;
        $data['render']         = $render;
        $data['goback']         = url('admin/'.$this->url_path.'/add');
        $data['module_name']    = $this->module_name;
        $data['path']           = $this->url_path;
        return view($this->url_path.'/list', $data);
    }
    /**
     * 列表
     */
    public function index_data()
    {
        $pages  = Db::table($this->table)->where(array('delete'=>0))->order('create_time desc')->paginate($this->pager);
        $lists  = $pages->all();
        foreach($lists as $key => $value){
            $op = '<a href="admin/channel/info/'.$value['id'].'">查看</a>';
            $op .= ' | ';
            $op .= '<a href="admin/channel/edit/'.$value['id'].'">编辑</a>';
            $op .= ' | ';
            $op .= '<a href="admin/channel/delete/'.$value['id'].'">删除</a>';
            $lists[$key]['op'] = $op;
        }
        $data = [
            'code'  => 0,
            'message' => '获取列表成功!',
            'data'=> $lists,
        ];
        $this->json($data);
    }

    /**
     * 详情
     */
    public function info()
    {
        $id = input('get.id');
        $info = Db::table($this->table)->where(array('id'=>$id))->find();

        $data['info'] = $info;
        $data['goback'] = url('admin/'.$this->url_path.'/list');
        $data['module_name'] = $this->module_name;
        return view($this->url_path.'/info', $data);
    }

    /**
     * 添加表单
     */
    public function add_form()
    {
        $data['goback'] = url('admin/'.$this->url_path.'/list');
        $data['action'] = url('admin/'.$this->url_path.'/add_submit');
        $data['module_name'] = $this->module_name;
        return view($this->url_path.'/add_form', $data);
    }

    /**
     * 添加表单提交
     */
    public function add_form_submit()
    {
        $formData = input('request.');
        $data = [
            'name'          => $formData['name'],
            'path'          => $formData['path'],
            'weight'        => $formData['weight'],
            'keyword'       => $formData['keyword'],
            'description'   => $formData['description'],
            'create_time'   => date("Y-m-d H:i:s", time()),
        ];
        $result = Db::table($this->table)->insert($data);
        if($result){
            $this->success('添加成功', 'admin/'.$this->url_path.'/add');
        }else{
            $this->error('添加失败');
        }
    }

    /**
     * 编辑表单
     */
    public function edit_form()
    {
        $id = input('get.id');
        $info = Db::table($this->table)->where(array('id'=>$id))->find();

        $data['info'] = $info;
        $data['goback'] = url('admin/'.$this->url_path.'/list');
        $data['action'] = url('admin/'.$this->url_path.'/edit_submit');
        $data['module_name'] = $this->module_name;
        return view($this->url_path.'/edit_form', $data);
    }

    /**
     * 编辑表单提交
     */
    public function edit_form_submit()
    {
        $formData = input('request.');
        $id = $formData['id'];
        $data = [
            'name'          => $formData['name'],
            'path'          => $formData['path'],
            'weight'        => $formData['weight'],
            'keyword'       => $formData['keyword'],
            'description'   => $formData['description'],
            'update_time'       => date("Y-m-d H:i:s", time()),
        ];
        $result = Db::table($this->table)->where(array('id'=>$id))->update($data);
        if($result){
            $this->success('编辑成功', 'admin/'.$this->url_path.'/edit?id='.$id);
        }else{
            $this->error('编辑失败');
        }
    }

    /**
     * 删除
     */
    public function delete()
    {
        $id = input('get.id');
        $data = [
            'delete' => 1,
        ];
        $result = Db::table($this->table)->where('id',$id)->update($data);
        if($result){
            $this->success('删除成功', 'admin/'.$this->url_path.'/list');
        }else{
            $this->error('删除失败');
        }
    }
}
