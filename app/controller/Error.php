<?php


namespace app\controller;


/**
 * Class Error
 * @package app\controller
 */
class Error extends Base
{
    public function index(): \think\Response
    {
        return $this->create([], '资源不存在', 404);
    }
}