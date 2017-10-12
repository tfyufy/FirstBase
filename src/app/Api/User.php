<?php
namespace App\Api;

use PhalApi\Api;

use App\Domain\UserDomain as UserDomain;

/**
 * 用户基本类  
 */

class User extends Api{
   
    public function getRules() {
        return array(
            'insertUser' => array(
                'nickname' => array('name' => 'nickname', 'require' => true),
                'password' => array('name' => 'password', 'require' => true, 'min' => 6),
            ),
			 'login' => array(
                'nickname' => array('name' => 'nickname', 'require' => true),
                'password' => array('name' => 'password', 'require' => true, 'min' => 6),
            )
        );
    }
	/**
	* 添加用户
	* @desc nickname pwd 必须
	* @return string msg
	*/
	public function insertUser(){
		$domain = new UserDomain();
		$newData = array(
            'nickname' => $this->nickname,
            'pwd' => $this->password,
        );
		$msg = $domain -> insert($newData);
		return array('msg'=> $msg);
	}
     /**
	* 用户登录
	* @desc nickname pwd 必须
	* @return string msg
	*/
	public function login(){
		$domain = new UserDomain();
		$newData = array(
            'nickname' => $this->nickname,
            'pwd' => $this->password,
        );
		$msg = $domain -> login($newData);
		return array('msg'=> $msg);
	}
	/**
	* 加密测试
	* @desc  加密测试
	*/
	public function encrypt(){
		$domain = new UserDomain();
		$domain->encrypt();
		return array('msg'=>"encrypt");
		
	}
	
	
	
	
	
	
}