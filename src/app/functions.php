<?php
namespace App;

    function hello(){
        return 'Hey, man~';
    }
    //加密
	function encrypt($pwd){
		//secho $pwd."\n";
		return md5(crypt($pwd,substr($pwd,2,4)));
		
	}