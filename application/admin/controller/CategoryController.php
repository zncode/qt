<?php
namespace app\admin\controller;

use app\index\controller\BaseController;
use think\Db;

class CategoryController extends BaseController
{
    public $pager = 20;
    public $table = 'zw_category';
    public $url_path = 'category';
    public $module_path = 'category';
    public $module_name = '栏目';

    public function __construct()
    {
        if(input('get.url_path')){
            $this->url_path = input('get.url_path');
        }
    }

    /**
     * 列表
     */
    public function index()
    {
        $url_path = input('get.url_path');
        $pages  = Db::table($this->table)->where(array('delete'=>0, 'parent'=>0))->order('create_time desc')->paginate($this->pager);
        $render = $pages->render();
        $lists  = $pages->all();

        if(is_array($lists) && count($lists)){
            foreach($lists as $key => $value){
                $channel = Db::table('zw_channel')->where(array('id'=>$value['channel_id']))->find();
                $lists[$key]['channel_name'] = $channel['name'];
                if($value['status'] ==  1){
                    $lists[$key]['status'] = '开放';
                }
                if($value['status'] ==  2){
                    $lists[$key]['status'] = '关闭';
                }

                //查找子栏目
                $sub_category = Db::table($this->table)->where(array('delete'=>0, 'parent'=>$value['id']))->order('create_time desc')->select();
                if(is_array($sub_category) && count($sub_category)){
                    foreach($sub_category as $key1 => $value1){
                        $channel1 = Db::table('zw_channel')->where(array('id'=>$value1['channel_id']))->find();
                        $sub_category[$key1]['channel_name'] = $channel1['name'];
                        if($value1['status'] ==  1){
                            $sub_category[$key1]['status'] = '开放';
                        }
                        if($value1['status'] ==  2){
                            $sub_category[$key1]['status'] = '关闭';
                        }

                    }
                }
                $lists[$key]['sub_category'] = $sub_category;
            }
        }

        $data['list']           = $lists;
        $data['render']         = $render;
        $data['goback']         = url('admin/'.$this->url_path.'/add?url_path='.$url_path);
        $data['module_name']    = $this->module_name;
        $data['path']           = $this->url_path;
        $data['url_path']       = $url_path;
        return view($this->module_path.'/list', $data);
    }

    /**
     * 详情
     */
    public function info()
    {
        $id = input('get.id');
        $info = Db::table($this->table)->where(array('id'=>$id))->find();

        $channel = Db::table('zw_channel')->where(array('id'=>$info['channel_id']))->find();

        $category = Db::table('zw_category')->where(array('parent'=>$info['parent']))->find();
        $info['channel_name'] = $channel['name'];

        if(is_array($category) && count($category)){
            $info['parent'] = $category['name'];
        }else{
            $info['parent'] = null;
        }
        if($info['status'] ==  1){
            $info['status'] = '开放';
        }
        if($info['status'] ==  2){
            $info['status'] = '关闭';
        }

        $data['info'] = $info;
        $data['goback'] = url('admin/'.$this->url_path.'/list?url_path='.$this->url_path);
        $data['module_name'] = $this->module_name;
        return view($this->module_path.'/info', $data);
    }

    /**
     * 添加表单
     */
    public function add_form()
    {
        $request = request();
        $url_path = input('get.url_path');

        $channels = Db::table('zw_channel')->select();
        $categorys = Db::table('zw_category')->where(array('parent'=>0, 'delete'=>0))->select();
        $data['channels'] = $channels;

        if(is_array($categorys) && count($categorys)){
            $data['cagetory'] = $categorys;
        }else{
            $data['cagetory'] = null;
        }

        $data['goback']         = url('admin/'.$this->url_path.'/list?url_type='.$this->url_path);
        $data['action'] = url('admin/'.$url_path.'/add_submit');
        $data['module_name'] = $this->module_name;
        $data['url_path'] = $url_path;
        return view($this->module_path.'/add_form', $data);
    }

    /**
     * 添加表单提交
     */
    public function add_form_submit()
    {
        $formData = input('request.');
        $data = [
            'parent'        => $formData['parent'],
            'channel_id'    => $formData['channel_id'],
            'name'          => $formData['name'],
            'status'        => $formData['status'],
            'weight'        => $formData['weight'],
            'keyword'       => $formData['keyword'],
            'description'   => $formData['description'],
            'create_time'   => date("Y-m-d H:i:s", time()),
        ];

        $result = Db::table($this->table)->insert($data);
        if($result){
            $this->success('添加成功', 'admin/'.$formData['url_path'].'/list?url_path='.$formData['url_path']);
        }else{
            $this->error('添加失败');
        }
    }

    /**
     * 编辑表单
     */
    public function edit_form()
    {
        $request = request();
        $id = input('get.id');
        $info = Db::table($this->table)->where(array('id'=>$id))->find();

        $channels = Db::table('zw_channel')->where(array('delete'=>0))->select();
        $categorys = Db::table('zw_category')->where(array('parent'=>0, 'delete'=>0))->select();
        $data['channels'] = $channels;

        if(is_array($categorys) && count($categorys)){
            $data['cagetory'] = $categorys;
        }else{
            $data['cagetory'] = null;
        }

        $data['info']           = $info;
        $data['goback']         = url('admin/'.$this->url_path.'/list?url_path='.$this->url_path);
        $data['action']         = url('admin/'.$this->url_path.'/edit_submit');
        $data['module_name']    = $this->module_name;
        $data['url_path']       = $this->url_path;

        return view($this->module_path.'/edit_form', $data);
    }

    /**
     * 编辑表单提交
     */
    public function edit_form_submit()
    {
        $formData = input('request.');
        $id = $formData['id'];
        $data = [
            'parent'        => $formData['parent'],
            'channel_id'    => $formData['channel_id'],
            'name'          => $formData['name'],
            'status'        => $formData['status'],
            'weight'        => $formData['weight'],
            'keyword'       => $formData['keyword'],
            'description'   => $formData['description'],
            'update_time'       => date("Y-m-d H:i:s", time()),
        ];
        $result = Db::table($this->table)->where(array('id'=>$id))->update($data);
        if($result){
            $this->success('编辑成功', 'admin/'.$formData['url_path'].'/edit?id='.$id.'&url_path='.$formData['url_path']);
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
            $this->success('删除成功', 'admin/'.$this->url_path.'/list?url_path='.$this->url_path);
        }else{
            $this->error('删除失败');
        }
    }
}
