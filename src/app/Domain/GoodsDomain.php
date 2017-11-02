<?php
namespace App\Domain;

use PhalApi\Exception\BadRequestException;

use App\Model\Goods as Goods;

use App\Model\Type as Type;

class GoodsDomain{
	
	//商品添加
	public function add($newData){
		$typemodel = new Type();
		//echo $typemodel->havetype($newData['type']);
		if(!$typemodel->havetype($newData['type']))
			throw new BadRequestException('没有该分类','11');
		$model = new Goods();
		$a = $model->insert($newData);
		if($a)
			return array('result' => 1,'rsptext' =>'商品id:'.$a);
		else 
			return array('result' => 0,'rsptext' =>'创建失败');
	}
	//商品删除
	public function del($id){
	    $model = new Goods();
	    if($model -> del($id))
			return array('result' => 1,'rsptext' =>'删除成功');
		else 
			return array('result' => 0,'rsptext' =>'删除失败或者商品id不存在');		
	}
	//修改商品
	public function updata($newData,$id){
		$typemodel = new Type();
		//echo $typemodel->havetype($newData['type']);
		if(!$typemodel->havetype($newData['type']))
			throw new BadRequestException('没有该分类，修改失败','11');
		$model = new Goods();
		$rs = $model -> updataType($id,$newData);
		if ($rs >= 1) {
          // 成功
		  return array('result' => 1,'rsptext' =>'修改成功');
        } else if ($rs === 0) {
         // 相同数据，无更新
		  return array('result' => 0,'rsptext' =>'数据无需更新或者商品ID不存在');
        } else if ($rs === false) {
          // 更新失败
		  throw new BadRequestException('更新失败','9');
        }
		
	}
	//getall  商品
	public function getAll(){
		$model = new Goods();
		$rs = $model -> getAllname();
		if($rs)
			return array('result' => 1,'rsptext' => $rs);
		else 
			return array('result' => 0,'rsptext' =>'获取失败');		
		
	}
	//get one 商品
	public function getoneClass($type){
		$typemodel = new Type();
		//echo $typemodel->havetype($newData['type']);
		if(!$typemodel->havetype($type))
			throw new BadRequestException('没有该分类','11');
	    $model = new Goods();
		$rs = $model -> getoneClass($type);
		if($rs)
			return array('result' => 1,'rsptext' => $rs);
		else 
			return array('result' => 0,'rsptext' =>'获取失败');		
	
	}
	
	
}