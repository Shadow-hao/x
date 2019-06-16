<?php
namespace app\index\controller;
use app\index\model\Index as model;
class Index extends Base
{
    public function index()
    {
        //获取用户权限
        $where = model::get_right(session('admin')['gid']);

        $data = model::get_menu($where);
        $this->assign('title','西瓜后台管理');
        $this->assign('data',$data);
        return $this->fetch();
    }
    //欢迎页面
    public function welcome(){




      $data1['users']=123;
        $this->assign('data1',$data1);
        return$this->fetch();
    }
    //清除缓存
    public function clear(){
        if (delete_dir_file(CACHE_PATH) && delete_dir_file(TEMP_PATH)) {
            return ['code'=>0,'message'=>'缓存清除成功'];
        }
        return ['code'=>1,'message'=>'缓存清除失败请重试'];
    }
    //清除日志
    public function c_log(){
        if (delete_dir_file(LOG_PATH)) {
            return ['code'=>0,'message'=>'日志清除成功'];
        }
        return ['code'=>1,'message'=>'日志清除失败请重试'];
    }
}
