<?php


namespace app\index\controller;


use app\index\model\Roles as model;
use think\Controller;
use app\index\model\Index;
use think\Db;

class Test extends Controller
{
    public function index(){
        dump(CACHE_PATH);
       // dump(TEMP_PATH);

    }
    public function index1(){
        $where = \app\index\model\Index::get_right(session('admin')['gid']);
        $data = Db::table('menu')->where('id','in',$where)->order('order','asc')->select();
        $data= byId($data);
        $data= genTree($data);
        print_r($data);
    }
}