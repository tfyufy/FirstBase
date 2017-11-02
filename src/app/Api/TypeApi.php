<?php
namespace App\Api;

use PhalApi\Api;

use PhalApi\Exception\BadRequestException;

use App\Domain\TypeDomain as GoodsTypeDomain;

/**
 * 分类名称 类 
 */

class TypeApi extends Api{
	
	
    public function getRules() {
        return array(
            'addtype' => array(
			    'name' => array('name' => 'name', 'require' => true, 'min' => 1),
                'describe' => array('name' => 'describe', 'require' => true,'min' => 10,'max' => 100 ),
            ),
			'deltype' => array(
			    'id' => array('name' => 'id', 'require' => true),
            ),
			'updatatype' => array(
			    'id' => array('name' => 'id', 'require' => true),
				'name' => array('name' => 'name', 'min' => 1),
                'describe' => array('name' => 'describe','min' => 10),
            ),
	     );
	
    }
	
	
	/**
	* 添加分类名称
	* @desc 返回的rsptext字段中含有物品分类ID
	* @return int result 0:失败 1：成功
	* @exception 412 货物名称存在
	*/
	public function addtype(){
	    $domain = new GoodsTypeDomain();
		$newData = array(
		     'typename' => $this->name,
			 'describe' => $this->describe,
		);
		return $domain -> add($newData);
	}
	
	/**
	* 删除分类名称
	* @desc 通过物品分类ID来删除
	* @return int result 0:失败 1：成功
	* @exception 410 货物id为空
	*/
	public function deltype(){
	    $domain = new GoodsTypeDomain();
	    if($this->id == null)
			throw new BadRequestException('货物id为空',10);
		return $domain -> del($this->id);
	}
	
	/**
	* 修改分类名称
	* @desc 通过物品分类ID来进行修改
	* @return int result 0:失败 1：成功
	* @exception 409 更新失败
	* @exception 410 货物id为空
	*/
	public function updatatype(){
		$domain = new GoodsTypeDomain();
		if($this->id == null)
			throw new BadRequestException('货物id为空',10);
		$newData = array();
		if(!$this->name == null)
			$newData['typename'] = $this ->name;
		if(!$this->describe == null)
			$newData['describe'] = $this ->describe;
		//var_dump ($newData);
		return $domain -> updata($newData,$this->id);
	}
	/**
	* 获取全部分类名称
	* @desc 
	* @return int result 0:失败 1：成功
	*/
	public function getAll(){
		$domain = new GoodsTypeDomain();
		return $domain -> getAll();
	}
}