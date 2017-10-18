<?php
namespace App\Api;

use PhalApi\Api;

use App\Domain\UserDomain as UserDomain;

/**
 * 用户基本类  
 */

class User extends Api{
    /* 1  //邮箱已近被注册
       2  //用户创建成功
       0  //邮箱格式错误
       3  //登陆成功
       4  //密码错误
       5  //用户不存在
       6  //发送邮件成功
       7  //发送邮件失败
       8  //验证码错误或者超时 300秒
    */
    public function getRules() {
        return array(
            'insertUser' => array(
			    'account' => array('name' => 'account', 'require' => true),
                'nickname' => array('name' => 'nickname', 'require' => true),
                'password' => array('name' => 'password', 'require' => true, 'min' => 6),
				'phonenum' => array('name' => 'phonenum'),
				'code' => array('name'=>'code','require' => true,'min' => 6, 'max' => 6),
            ),
			 'login' => array(
                'account' => array('name' => 'account', 'require' => true),
                'password' => array('name' => 'password', 'require' => true, 'min' => 6),
				'code' => array('name'=>'code','require' => true,'min' => 6, 'max' => 6),
            ),
			 'sendmail' => array(
                'account' => array('name' => 'account', 'require' => true),
				'nickname' => array('name' => 'nickname', ),
            )
        );
    }
	/**
	* 添加用户
	* @desc nickname pwd accont必须 phonenum可选
	* @return int data 
	*/
	public function insertUser(){
		$domain = new UserDomain();
		$pwd = $domain->encrypt($this->password);
		$newData = array(
            'nickname' => $this->nickname,
            'pwd' => $pwd,
			'account' => $this->account,
			'phonenum' => $this->phonenum,
			'code'=> $this->code,
        );
		return $domain -> insert($newData);
	}
     /**
	* 用户登录
	* @desc nickname pwd code必须
	* @return int data 
	*/
	public function login(){
		$domain = new UserDomain();
		$pwd = $domain->encrypt($this->password);
		$newData = array(
            'account' => $this->account,
            'pwd' => $pwd,
			'code'=> $this->code,
        );
		return  $domain -> login($newData);
	}
	
	/**
	* 发送邮箱验证码
	* @desc account 必须
	* @return int data 
	*/
	public function sendmail(){
		$domain = new UserDomain();
		$newData = array(
		'account' => $this->account,
		'nickname' => $this->nickname,
		);
		return $domain->send($newData);
	
	}
	
	
	
	
	
}