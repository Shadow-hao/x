<?php


namespace app\index\model;


use think\Db;
use think\Model;

class Article extends Model
{
    protected function getGidAttr($value){
        $gid = Db::name('account')->column('username', 'id');
        return $gid[$value];
    }
    protected function setGidAttr($value){
    $gid = Db::name('account')->column('username', 'id');
       $key=  array_search($value,$gid);
        return $key;
    }


}