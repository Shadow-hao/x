<?php


namespace app\index\controller;

use app\index\model\Article as model;
class Article extends Base
{
    // 文章列表
    public function index(){
        $order['0'] ='id';
        $order['1'] ='desc';
        $order1='id,desc';
        $where1='title';
        if ($post = input('post.')){
            $order1= $post['order'];
            $order = explode(",", $post['order']);

        }

        $data = model::order( $order['0'], $order['1'])->order('create_time','asc')->paginate(7);
       //搜索
        if (input('get.text')){
            $s_data = input('get.');
            $where ='%'.$s_data['text'].'%';
            $this->assign('text',$s_data['text']);
            $this->assign('where',$where);
            $data= model::order( $order['0'], $order['1'])->order('create_time','asc')->where("title",'like',$where)->paginate(1);
        }
        //分页
        $page = input('get.page');
        if (!!$page) {
            $page = input('get.');
            $order1 = $page['order'];
            $p_order = explode(",", $page['order']);
            dump($page);
            //搜索后分页
             if (!$page['id']==null){
                 $where=$page['id'];
                 $this->assign('where',$where);
                 $data= model::order( $order['0'], $order['1'])->order('create_time','asc')->where("title",'like',$where)->paginate(1);
             }
          //  $data= model::order( $p_order['0'], $p_order['1'])->order('create_time','asc')->paginate(7);
        }

        $this->assign('order1', $order1);
        $this->assign('select', $where1);
        $this->assign('data',$data);
        return  $this->fetch();
    }
    //文章添加
    public function add(){
       return $this->fetch();
    }
    //文章保存
    public function save(){
       $data =  input('post.');
      // dump($data);
       if (!model::create($data)) {
          return ['code'=>1,'message'=>'文章添加失败'];
       }
        return ['code'=>0,'message'=>'文章添加成功'];
    }
    //文章编辑
    public function edit(){
      $id = (int)input('get.id');
      $data = model::get($id);
      if ($u_data = input('post.')){
        if (!model::where('id',$u_data['id'])->update($u_data)){

           return ['code'=>1,'message'=>'文章更新失败'];
        }
          return ['code'=>0,'message'=>'文章更新成功'];
      }
      $this->assign('data',$data);
        return $this->fetch();
    }
    //文章删除
    public function del(){
       $id = (int)input('post.id');
        if (!model::destroy($id)){
            return ['code'=>1,'message'=>'文章删除失败'];
        }
        return ['code'=>0,'message'=>'文章删除成功'];
    }
    //缩略图上传
    public function uploads(){
        $file = request()->file('file');
        if ($file==null){
            return ['code'=>1,'message'=>"没有文件上传"];
        }
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads'.DS.'thumb');
            if($info){
                // 成功上传后 获取上传信息

                $ext= $info->getExtension();//文件格式
                if (!in_array($ext,['jpg','jpeg','gif','pang'])){
                    return ['code'=>2,'message'=>"不支持此图片格式"];
                }
                //文件路径
               // echo $info->getSaveName();// 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                $img_src= '/uploads/thumb/'.$info->getSaveName();
                return ['code'=>0,'message'=>$img_src];
                //echo $info->getFilename();// 输出 42a79759f284b767dfcb2a0197904287.jpg
            }else{
                // 上传失败获取错误信息
                return ['code'=>3,'message'=>$file->getError()];

            }
        }
    }
}