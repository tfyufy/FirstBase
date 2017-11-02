<?php

namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

class Type extends NotORM{
	
	
	protected function getTableName($id) {
        return "goodstype";
    }
	//删除分类名称
	public function del($id){
	    $user = $this->getORM()
			         ->where('goodstype_id',$id);
	    return $user->delete();
	}
	//修改分类名称信息
	public function updataType($id,$data){
		$user = $this->getORM()
			         ->where('goodstype_id',$id);
		
		return $user->update($data);
	}
	//获取全部分类名称信息
	public function getAllname(){
	    $user = $this->getORM()
		             ->select('*');
		$arr = array();
        while ($row = $user->fetch()) {
             array_push($arr,$row);
        }
		return $arr;
	}
	//查询是否含有该分类ID
	public function havetype($id){
	    $user = $this->getORM()
		             ->where('goodstype_id', $id); 
        if($user->count() != 0) 
         return 1;
		else 
         return 0;			
	}
	//查询是否含有该分类名称
	public function havename($name){
	    $user = $this->getORM()
		             ->where('typename', $name); 
        if($user->count() != 0) 
         return 1;
		else 
         return 0;			
	}
	
}