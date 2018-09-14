<?php
namespace app\admin\controller;

use think\Controller;

class BaseController extends Controller
{
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
}
