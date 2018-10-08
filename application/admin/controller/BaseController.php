<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;

class BaseController extends Controller
{
    public $user_id = null; //登录用户id

    /**
     * 初始化
     * @author
     */
    public function _initialize(){
        $request = request();
        $path = $request->path();
        if(!$this->public_path($path)){
            if(Session::has('user_id')){
                $this->user_id = Session::get('user_id');
            }else{
                if($path != 'admin/user/login'){
                    $this->redirect('admin/user/login');
                }
            }
        }
    }

    public function get_document_root_dir(){
        $document_root = NULL;
        $system = php_uname('s');
        if($system == 'Linux'){
            $document_root = $_SERVER['DOCUMENT_ROOT'];
        }else{
            $document_root = $_SERVER['DOCUMENT_ROOT'];
        }

        return $document_root;
    }

    public function json($data){
        echo json_encode($data);
        die;
    }

    /**
     * 不需要权限检查的路径
     */
    public function public_path($path){
        $data = [
            'admin/user/login_submit',
            'admin/user/register',
            'admin/user/register_submit',
        ];

        foreach($data as $key => $value){
            if($path == $value){
                return true;
            }
        }

        return false;
    }
}
