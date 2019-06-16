<?php


namespace app\index\controller;


class Site extends Base
{
        public function index(){
            return   $this->fetch();
        }

}