<?php
declare (strict_types = 1);

namespace app\controller;

use think\exception\ValidateException;
use think\facade\Validate;
use think\Request;
use app\model\User as UserModel;
use think\Response;
use app\validate\User as UserValidate;

class User extends Base
{
    /**
     * 显示资源列表
     *
     * @return Response
     */
    public function index()
    {
        $data = UserModel::field('id, username, gender, email')->select();

        if ($data->isEmpty()){
            return $this->create([], '无数据', 204);
        }
        return $this->create($data, '数据请求成功', 200);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return Response
     */
    public function save(Request $request)
    {
        $data = $request->param();

        try{
            validate(UserValidate::class)->check($data);
        }catch (ValidateException $exception){
            return $this->create([], $exception->getError(), 400);
        }

        $data['password'] = sha1($data['password']);

        $id = UserModel::create($data)->getData('id');

        if (empty($id)){
            return $this->create([], '注册失败', 400);
        }else {
            return $this->create($id, '注册成功', 200);
        }
    }

    /**
     * 显示指定的资源
     *
     * @param int $id
     * @return Response
     */
    public function read(int $id): Response
    {
        if (!Validate::isInteger($id)){
            return $this->create([], 'id参数不合法', 400);
        }

        $data = UserModel::find($id);

        if (empty($data)){
            return $this->create([], '无数据', 204);
        }
        return $this->create($data, '数据请求成功', 200);

    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
        //
    }
}
