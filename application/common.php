<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//解决浏览器缓存css导致的不生效
function stamp($file){
    $path= APP_STATIC.$file;
    return "/static/".$file."?v=".filemtime($path);
}
//以ID为索引
function byId($data){
    $list=[];
    foreach ($data as $v){
        $list[$v['id']]=$v;
    }
    return $list;
}
function genTree($items) {
    $tree = array(); //格式化好的树
    foreach ($items as $item)
        if (isset($items[$item['pid']]))
            $items[$item['pid']]['son'][] = &$items[$item['id']];
        else
            $tree[] = &$items[$item['id']];
    return $tree;
}
/**
 * 循环删除目录和文件
 * @param string $dir_name 目录名
 * @return bool
 */
function delete_dir_file($dir_name) {
    $result = false;
    if(is_dir($dir_name)) { //检查指定的文件是否是一个目录
        if ($handle = opendir($dir_name)) {   //打开目录读取内容
            while (false !== ($item = readdir($handle))) { //读取内容
                if ($item != '.' && $item != '..') {
                    if (is_dir($dir_name . DS . $item)) {
                        delete_dir_file($dir_name . DS . $item);
                    } else {
                        unlink($dir_name . DS . $item);  //删除文件
                    }
                }
            }
            closedir($handle);  //打开一个目录，读取它的内容，然后关闭
            if (rmdir($dir_name)) { //删除空白目录
                $result = true;
            }
        }
    }


    return $result;


}