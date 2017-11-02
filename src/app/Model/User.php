<?php

namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

class User extends NotORM{
	
	
	protected function getTableName($id) {
        return "user";
    }
	// 验证用户是否存在
	public function getAccount($account){
		$name = $this->getORM()
			  ->where('account',$account);
	     if($name->count() != 0) {
		  return $name->fetchOne();
		 } else 
		  return "0";
	}
}