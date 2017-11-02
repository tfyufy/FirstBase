<?php
namespace App\Domain;

use App\Model\User as UserModel;

use App\Model\EmailClass as EmailModel;

use App\Model\Code as CodeModel;

use PhalApi\Exception\BadRequestException;





class UserDomain{
	//用户添加
	public function insert($userData,$code){
		
		$model = new UserModel();
		$codemodel = new CodeModel();
		$res = $model->getAccount($userData['account']);
		if(!$codemodel->verificationcode($userData['account'],$code)){
			throw new BadRequestException('验证码验证失败或者超时300秒','8');
		}else  if($res != "0"){
			throw new BadRequestException('邮箱已近被注册','2');
		}else 
		{
		    if($model->insert($userData))
				return array('result' => 1,'rsptext' => '注册成功');
			else 
				return array('result' => 0,'rsptext' =>'注册失败');
		}
		
	}
	//用户登录
	public function login($userData){
		$model = new UserModel();
		$codemodel = new CodeModel();
		$res = $model->getAccount($userData['account']);
		if($res != "0"){
			//\PhalApi\DI()->logger->debug($res['pwd']);
			//var_dump($res);
            if($userData['pwd'] == $res['pwd']){
			return array('result' => 1,'rsptext' =>'登陆成功'); //登录成功   	
			}else 
			throw new BadRequestException('密码错误','4');
		}else {
		    throw new BadRequestException('用户不存在','5');
		}
		
	}
	
	
	
	//发送邮件和验证码存储
	public function send($newData){
		$code = rand(100000,999999);
		//echo $newData['nickname'];
		$emailmodel = new EmailModel();
        $rtn= $emailmodel -> sendMail($newData['account'],$newData['nickname'],'验证码',$code);
	    if($rtn){
			$codemodel = new CodeModel();
			$codemodel->setcode($newData['account'],$code);
			return array('result' => 1,'rsptext' =>'邮件发送成功');
		}else {
			return array('result' => 0,'rsptext' =>'邮件发送失败');
		}
	
		
	}
	

	
	
	
}
