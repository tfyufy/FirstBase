<?php

namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

class Goods extends NotORM{
	
	
	protected function getTableName($id) {
        return "goods";
    }
	//删除商品
	public function del($id){
	    $user = $this->getORM()
			         ->where('goods_id',$id);
	    return $user->delete();
	}
	//修改商品信息
	public function updataType($id,$data){
		$user = $this->getORM()
			         ->where('goods_id',$id);
		return $user->update($data);
	}
	//获取全部商品信息
	public function getAllname(){
	    $user = $this->getORM()
		             ->select('*');
		$arr = array();
        while ($row = $user->fetch()) {
             array_push($arr,$row);
        }
		return $arr;
	}
	//获取一类商品信息
	public function getoneClass($type){
	    $user = $this->getORM()
		             ->select('*')
					 ->where('type',$type);
		$arr = array();
        while ($row = $user->fetch()) {
             array_push($arr,$row);
        }
		return $arr;
	}
	
	
}