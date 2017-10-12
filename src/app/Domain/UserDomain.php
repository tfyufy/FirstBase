<?php
namespace App\Domain;

use App\Model\User as UserModel;

class UserDomain{
	//用户添加
	public function insert($userData){
		
		$model = new UserModel();
		$res = $model->getName($userData['nickname']);
		if($res != "0"){
			return "用户名已存在";
		}else 
		{
		    $model->insert($userData);
		    return "用户创建成功";
		}
		
	}
	//用户登录
	public function login($userData){
		$model = new UserModel();
		$res = $model->getName($userData['nickname']);
		if($res != "0"){
			//\PhalApi\DI()->logger->debug($res['pwd']);
			//var_dump($res);
            if($userData['pwd'] == $res['pwd']){
			return "登录成功";    	
			}else 
			return "密码错误";
		}else 
		{
		    return "用户不存在";
		}
		
	}
	
	//加密测试
	public function encrypt(){
		$name = 'TFYUFY';
        $encodeName = base64_encode($name);
        echo $encodeName . "\n";
        echo base64_decode($encodeName);
		return 0;
		
	}
	
	
	
	
	
}