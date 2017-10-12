<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

class User extends NotORM{
	
	
	protected function getTableName($id) {
        return "user";
    }
	//获取列表名单
	public function getNameList(){
		$user = $this->getORM();
		return $user->select("name");
	}
	// 验证用户是否存在
	public function getName($name){
		$name = $this->getORM()
			  ->where('nickname',$name);
	     if($name->count() != 0) {
		  return $name->fetchOne();
		 } else 
		  return "0";
	}
	
	
}