<?php
namespace app\admin\controller;

use app\admin\controller\BaseController;

class IndexController extends BaseController
{
    public function index()
    {
        return view('index/index');
    }

    public function resource_list()
    {
//        echo 'test';die;
        return view('index/resource_list');
    }
}
