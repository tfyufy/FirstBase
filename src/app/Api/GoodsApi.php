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
				'pic' => array(
                    'name' => 'pic',        // 客户端上传的文件字段
                    'type' => 'file', 
                    'require' => true, 
                    'max' => 2097152,        // 最大允许上传2M = 2 * 1024 * 1024, 
                    'range' => array('image/jpeg', 'image/png'),  // 允许的文件格式
                    'ext' => 'jpeg,jpg,png', // 允许的文件扩展名 
                    'desc' => '待上传的图片文件',
                ),
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
	* @exception 410 分类id为空
	* @exception 411 没有该分类
	*/
	public function addgoods(){
		$code = 0;
		if($this->type == null)
			throw new BadRequestException('分类id为空',10);
		
		$tmpName = $this->pic['tmp_name'];
        $name = md5($this->name . $_SERVER['REQUEST_TIME']);
        $ext = strrchr($this->pic['name'], '.');
		//echo($ext);
		//echo(API_ROOT);
        $uploadFolder = sprintf('%s/public/uploads/', API_ROOT);
        if (!is_dir($uploadFolder)) {
			mkdir($uploadFolder, 0777);
        }

        $imgPath = $uploadFolder .  $name . $ext;
        if (move_uploaded_file($tmpName, $imgPath)) {
            $code = 1;
            $pic= sprintf('http://%s/firstbase/public/uploads/%s%s', $_SERVER['SERVER_NAME'], $name, $ext);
        }
		
		if($code != 1){
		    return array('result' => 0,'rsptext' =>'图片上传失败');
		}
		$domain = new GoodsDomain();
		$newData = array(
		     'name' => $this->name,
			 'describe' => $this->describe,
			 'pic' => $pic,
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