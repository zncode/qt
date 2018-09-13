<?php
namespace app\api\controller;

use think\Controller;

class BaseController extends Controller
{
    public $debug = 1;      //开启调式模式=1
    public $token = '123';
}
