<?php
namespace App\Api;

use PhalApi\Api;

use App\Domain\UserDomain as UserDomain;

use PhalApi\Exception\BadRequestException;



/**
 * 用户基本类  
 */

class User extends Api{

    public function getRules() {
        return array(
            'insertUser' => array(
			    'account' => array('name' => 'account', 'require' => true),
                'nickname' => array('name' => 'nickname', 'require' => true, 'min' => 4, 'max' =>10),
                'password' => array('name' => 'password', 'require' => true, 'min' => 6),
				'phonenum' => array('name' => 'phonenum'),
				'code' => array('name'=>'code','require' => true,'min' => 6, 'max' => 6),
            ),
			 'login' => array(
                'account' => array('name' => 'account', 'require' => true),
                'password' => array('name' => 'password', 'require' => true, 'min' => 6),
            ),
			 'sendmail' => array(
                'account' => array('name' => 'account', 'require' => true),
				'nickname' => array('name' => 'nickname','min' => 4, 'max' =>10 ),
            )
        );
    }
	/**
	* 添加用户
	* @desc account目前对应的是邮箱账号
	* @return int result 0:失败 1：成功
	* @exception 400 参数不合法
	* @exception 401 邮箱格式错误
	* @exception 402 邮箱已近被注册
	* @exception 408 验证码错误或者超时 300秒
	*/
	public function insertUser(){
		if($this->account == null)
			throw new BadRequestException('邮箱为空');
		if(!filter_var($this->account, FILTER_VALIDATE_EMAIL))
			throw new BadRequestException('邮箱格式错误','1');
		$domain = new UserDomain();
		$pwd = \App\encrypt($this->password);
		$newData = array(
            'nickname' => $this->nickname,
            'pwd' => $pwd,
			'account' => $this->account,
			'phonenum' => $this->phonenum,
        );
		return $domain -> insert($newData,$this->code);
	}
     /**
	* 用户登录
	* @desc account目前对应的是邮箱账号
	* @return int result 1,成功 0，失败
	* @exception 401 邮箱格式错误
	* @exception 404 密码错误
	* @exception 405 用户不存在
	* @exception 408 验证码错误或者超时 300秒
	*/
	public function login(){
		if(!filter_var($this->account, FILTER_VALIDATE_EMAIL))
			throw new BadRequestException('邮箱格式错误','1');
		$domain = new UserDomain();
		$pwd =\App\encrypt($this->password);
		$newData = array(
            'account' => $this->account,
            'pwd' => $pwd,
        );
		return  $domain -> login($newData);
	}
	
	/**
	* 发送邮箱验证码
	* @desc account目前对应的是邮箱账号
	* @return int result 1,发送邮件成功  0,发送邮件失败 
	* @exception 400 参数不合法
	* @exception 401 邮箱格式错误
	*/
	public function sendmail(){
		if($this->account == null)
			throw new BadRequestException('邮箱为空');
		if(!filter_var($this->account, FILTER_VALIDATE_EMAIL))
			throw new BadRequestException('邮箱格式错误','1');
		$domain = new UserDomain();
		$newData = array(
		'account' => $this->account,
		'nickname' => $this->nickname,
		);
		return  $domain->send($newData);
	
	}
	/**
	* 测试
	* @desc account 
	*/
	public function test(){
		
	     
		return (filter_var('m15107087226163.com', FILTER_VALIDATE_EMAIL));  
	
	}
	
	
	
	
}