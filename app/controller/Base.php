<?php


namespace app\controller;


use think\facade\Config;
use think\facade\Request;
use think\Response;

/**
 * Class Base
 * @package app\controller
 */
abstract class Base
{
    /**
     * @var int
     */
    protected $page;

    /**
     * @var int
     */
    protected $pageSize;

    /**
     * Base constructor.
     */
    public function __construct()
    {
        $this->page = (int)Request::param('page');

        $this->pageSize = (int)Request::param('page_size', Config::get('app.page_size'));
    }

    /**
     * @param $data
     * @param string $msg
     * @param int $code
     * @param string $type
     * @return Response
     */
    protected function create($data, string $msg = '', int $code = 200, string $type = 'json'): Response
    {
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data
        ];

        return Response::create($result, $type);
    }

    /**
     * @param $name
     * @param $arguments
     * @return Response
     */
    public function __call($name, $arguments): Response
    {
        return $this->create([], '资源不存在', 404);
    }
}