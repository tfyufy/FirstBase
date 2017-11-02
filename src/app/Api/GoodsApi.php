<?php
namespace App\Api;

use PhalApi\Api;

use PhalApi\Exception\BadRequestException;

use App\Domain\GoodsDomain as GoodsDomain;

/**
 * 商品类 
 */

class GoodsApi extends Api{
	
	
    public function getRules() {
        return array(
            'addgoods' => array(
			    'name' => array('name' => 'name', 'require' => true, 'min' => 1),
                'type' => array('name' => 'type', 'require' => true),
				'pic' => array('name' => 'pic', 'require' => true),
				'describe' => array('name' => 'describe', 'require' => true,'min' =>10 ,'max' =>100 ),
				'num' => array('name' => 'num', 'require' => true,'min'=>1),
				'price' => array('name' => 'price', 'require' => true,'min'=>1),
				
            ),
			'delgoods' => array(
			    'id' => array('name' => 'id', 'require' => true),
            ),
			'updatagoods' => array(
			    'id' => array('name' => 'id', 'require' => true),
				'name' => array('name' => 'name', 'min' => 1),
                'type' => array('name' => 'type'),
				'pic' => array('name' => 'pic'),
				'describe' => array('name' => 'describe', 'min' =>10 ,'max' =>100 ),
				'num' => array('name' => 'num', 'min'=>1),
				'price' => array('name' => 'price', 'min'=>1),
            ),
			'getoneClass' => array(
			    'type' => array('name' => 'type', 'require' => true),
            ),
			
	     );
	
    }
	
	
	/**
	* 添加商品
	* @desc 返回的rsptext字段中含有商品ID
	* @return int result 0:失败 1：成功
	* @exception 410 分类id为空或者图片地址为空
	* @exception 411 没有该分类
	*/
	public function addgoods(){
		if($this->type == null)
			throw new BadRequestException('分类id为空',10);
		if($this->pic == null)
			throw new BadRequestException('商品图片地址为空',10);
	    $domain = new GoodsDomain();
		$newData = array(
		     'name' => $this->name,
			 'describe' => $this->describe,
			 'pic' => $this->pic,
			 'remaining_number' => $this->num,
			 'price' => $this->price,
			 'type' => $this->type,
		);
		return $domain -> add($newData);
	}
	
	/**
	* 删除商品
	* @desc 通过物品分类ID来删除
	* @return int result 0:失败 1：成功
	* @exception 410 商品id为空
	*/
	public function delgoods(){
	    $domain = new GoodsDomain();
	    if($this->id == null)
			throw new BadRequestException('商品id为空',10);
		return $domain -> del($this->id);
	}
	
	/**
	* 修改商品
	* @desc 通过商品ID来进行修改，修改分类需要分类名称的ID
	* @return int result 0:失败 1：成功
	* @exception 409 更新失败
	* @exception 410 商品id为空
	* @exception 411 没有该分类
	*/
	public function updatagoods(){
		$domain = new GoodsDomain();
		if($this->id == null)
			throw new BadRequestException('商品id为空',10);
		$newData = array();
		if(!$this->name == null)
			$newData['name'] = $this ->name;
		if(!$this->describe == null)
			$newData['describe'] = $this ->describe;
		if(!$this->pic == null)
			$newData['pic'] = $this ->pic;
		if(!$this->num == null)
			$newData['remaining_number'] = $this ->num;
		if(!$this->price == null)
			$newData['price'] = $this ->price;
		if(!$this->describe == null)
			$newData['type'] = $this ->type;
		//var_dump ($newData);
		return $domain -> updata($newData,$this->id);
	}
	/**
	* 获取全部商品信息
	* @desc 
	* @return int result 0:失败 1：成功
	*/
	public function getAll(){
		$domain = new GoodsDomain();
		return $domain -> getAll();
	}
	/**
	* 获取单个分类下的商品信息
	* @desc 通过物品分类ID来进行获取此类全部商品信息
	* @return int result 0:失败 1：成功
	* @exception 411 没有该分类
	*/
	public function getoneClass(){
		$domain = new GoodsDomain();
		return $domain -> getoneClass($this->type);
	}
	
}