<?php

namespace App\Model;


class Code{
	
	//验证验证码  
	public function  verificationcode($account,$code){
		$redis = new \redis();
		$redis_config = \PhalApi\DI()->config->get('app.redisconfig');
        $redis->connect( $redis_config['host'],$redis_config['port']);
		/*if(!$redis->get($account)){
			echo('timeout');
		}*/
        if($code == $redis->get($account)){
            return true;
		}else {
		    return false;
		}			
		
		
	}
	// 验证码 存储 
	public function setcode($account,$code){
		$redis = new \redis();
		$redis_config = \PhalApi\DI()->config->get('app.redisconfig');
        $redis->connect( $redis_config['host'],$redis_config['port']);
	    $redis -> setex($account,300,$code);//设置验证码 key-value 300秒
		return 0;
		
	}

		
		
	
}