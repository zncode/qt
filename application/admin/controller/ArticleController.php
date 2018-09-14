<?php
namespace app\admin\controller;

use app\index\controller\BaseController;
use think\Db;

class ArticleController extends BaseController
{
    public $pager = 20;
    public $table = 'zw_article';
    public $url_path = 'article';
    public $module_name = '文章';

    /**
     * 列表
     */
    public function index()
    {
        $keyword = input('get.keyword') ? input('get.keyword') : NULL;
        if($keyword){
            $where['title'] = ['like', '%'.$keyword.'%'];
        }
        $where['delete'] = 0;

        $pages  = Db::table($this->table)->where($where)->order('create_time desc')->paginate($this->pager);
        $render = $pages->render();
        $lists  = $pages->all();

        if(is_array($lists) && count($lists)){
            foreach($lists as $key => $value){
                $lists[$key]['picture_number'] = 0;
            }
        }

        $data['list'] = $lists;
        $data['render'] = $render;
        $data['goback'] = url('admin/'.$this->url_path.'/add');
        $data['module_name']    = $this->module_name;
        $data['path']           = $this->url_path;
        $data['action']         = url('admin/'.$this->url_path.'/list');
        return view($this->url_path.'/list', $data);
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
        $data['module_name']    = $this->module_name;
        return view($this->url_path.'/info', $data);
    }

    /**
     * 添加表单
     */
    public function add_form()
    {
        $data['goback'] = url('admin/'.$this->url_path.'/list');
        $data['action'] = url('admin/'.$this->url_path.'/add_submit');
        $data['module_name']    = $this->module_name;
        $data['upload_image']   = url('/upload/image_editor');
        return view($this->url_path.'/add_form', $data);
    }

    /**
     * 添加表单提交
     */
    public function add_form_submit()
    {
        $formData = input('request.');

        $data = [
            'category_id'       => $formData['category_id'],
            'status'            => $formData['status'],
            'source'            => $formData['source'],
            'author'            => $formData['author'],
            'meta_keyword'      => $formData['meta_keyword'],
            'meta_description'  => $formData['meta_description'],
            'summary'           => $formData['summary'],
            'title'             => $formData['title'],
            'content'           => $formData['content'],
            'create_time'       => date("Y-m-d H:i:s", time()),
        ];
        $result = Db::table($this->table)->insert($data);
        $id = Db::table($this->table)->getLastInsID();

        //更新图片
        if(is_array($formData['upload_images']) && count($formData['upload_images'])){
            foreach($formData['upload_images'] as $picture_name){
                Db::table($this->table.'_picture')->where(array('picture_name'=>$picture_name))->update(array('article_id'=>$id));
            }
        }
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
        $data['module_name']    = $this->module_name;
        return view($this->url_path.'/edit_form', $data);
    }

    /**
     * 编辑文章表单提交
     */
    public function edit_form_submit()
    {
        $formData = input('request.');
        $id = $formData['id'];
        $data = [
            'category_id'       => $formData['category_id'],
            'status'            => $formData['status'],
            'source'            => $formData['source'],
            'author'            => $formData['author'],
            'meta_keyword'      => $formData['meta_keyword'],
            'meta_description'  => $formData['meta_description'],
            'summary'           => $formData['summary'],
            'title'             => $formData['title'],
            'content'           => $formData['content'],
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
     * 删除文章
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

    public function test(){
        echo $_SERVER['PHP_SELF'];
    }
}
