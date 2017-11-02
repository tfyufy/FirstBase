<?php
namespace App\Domain;

use PhalApi\Exception\BadRequestException;

use App\Model\Type as Type;

class TypeDomain{
	
	//分类名称添加
	public function add($newData){
		$model = new Type();
		if($model->havename($newData['typename']))
			throw new BadRequestException('分类名称存在','12');
		$a = $model->insert($newData);
		if($a)
			return array('result' => 1,'rsptext' =>'分类名称id:'.$a);
		else 
			return array('result' => 0,'rsptext' =>'创建失败');
	}
	//分类名称删除
	public function del($id){
	    $model = new Type();
	    if($model -> del($id))
			return array('result' => 1,'rsptext' =>'删除成功');
		else 
			return array('result' => 0,'rsptext' =>'删除失败或者分类名称id不存在');		
	}
	//修改分类名称
	public function updata($newData,$id){
		$model = new Type();
		$rs = $model -> updataType($id,$newData);
		if ($rs >= 1) {
          // 成功
		  return array('result' => 1,'rsptext' =>'修改成功');
        } else if ($rs === 0) {
         // 相同数据，无更新
		  return array('result' => 0,'rsptext' =>'数据无需更新或者分类名称ID不存在');
        } else if ($rs === false) {
          // 更新失败
		  throw new BadRequestException('更新失败','9');
        }
		
	}
	//getall  分类名称
	public function getAll(){
		$model = new Type();
		$rs = $model -> getAllname();
		if($rs)
			return array('result' => 1,'rsptext' => $rs);
		else 
			return array('result' => 0,'rsptext' =>'获取失败');		
		
	}
	
	
}