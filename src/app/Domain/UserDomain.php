<?php
namespace App\Domain;

use App\Model\User as UserModel;

use App\Model\Code as CodeModel;

require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer as mailer;



class UserDomain{
	//用户添加
	public function insert($userData){
		
		$model = new UserModel();
		$res = $model->getAccount($userData['account']);
		if(!$this->verificationcode($userData['account'],$userData['code'])){
			return 8;
		}else if($this->validatemail($userData['account'])){
			return 0;
		}else if($res != "0"){
			return 1;
		}else 
		{
		    $model->insert($userData);
		    return 2;
		}
		
	}
	//用户登录
	public function login($userData){
		$model = new UserModel();
		$res = $model->getAccount($userData['account']);
		if(!$this->verificationcode($userData['account'],$userData['code'])){
			return 8;
		}else if($res != "0"){
			//\PhalApi\DI()->logger->debug($res['pwd']);
			//var_dump($res);
            if($userData['pwd'] == $res['pwd']){
			return 3;    	
			}else 
			return 4;
		}else 
		{
		    return 5;
		}
		
	}
	
	//加密
	public function encrypt($pwd){
		//secho $pwd."\n";
		return md5(crypt($pwd,substr($pwd,2,4)));
		
	}
	
	//发送邮件和验证码存储
	public function send($newData){
		$code = rand(100000,999999);
		echo $newData['nickname'];
        $rtn= $this -> sendMail($newData['account'],$newData['nickname'],'验证码',$code);
		if($this->validatemail($newData['account'])){
		    return 0;
		}else if($rtn){
			$model = new CodeModel();
			$res = $model->getAccount($newData['account']);
			if($res != '0'){
			  $newData = array('code' => $code,'time'=>time());
			  $model->update($res['id'],$newData);
			}else {
			$newData = array(
            'account' => $newData['account'],
            'code' => $code,
			'time' => time(),
            );
			$model->insert($newData);
			}
			return 6;
		}else {
			return 7;
		}
	
		
	}
	//邮件发送的方法phpmailer
	public function sendMail($to,$nickname,$title,$content){
        $mail = new mailer\PHPMailer();
        $mail->SMTPDebug = 0;//debug
        $mail->isSMTP();
        $mail->SMTPAuth=true;
        $mail->Host = 'smtp.qq.com';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->CharSet = 'UTF-8';
        $mail->FromName = 'TFYUFY';
        $mail->Username ='287170715@qq.com';
        $mail->Password = 'qhbsknmrtaqmcbad';
        $mail->From = '287170715@qq.com';
        $mail->isHTML(true); 
        $mail->addAddress($to,$nickname);
        $mail->Subject = $title;
        //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
        $mail->Body = $this->getCodeHtml($content);
        //为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
        // $mail->addAttachment('./d.jpg','mm.jpg');
        //同样该方法可以多次调用 上传多个附件
        // $mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');
        
        $status = $mail->send();
        if($status) {
            return true;
          }else{
            return false;
          }
    }
	//验证邮箱格式
	public function validatemail($mailaddress){
		$email = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
		if(preg_match($email, $mailaddress)){
		    return false;
		}else {
			return true;
		}
		
	}
	//验证验证码  3 验证成功  2 验证码错误  1 验证码过期或者其他情况
	public function  verificationcode($account,$code){
		$model = new CodeModel();
		$res = $model->getAccount($account);
		if($res != '0'){
			if((time()-$res['time'])>300)
				return false;
		   	else if( $res['code']==$code )
				return true;
			else 
				return false;
		}else 
			return false;
		
	}
	
	//html格式验证码
	public function getCodeHtml($code){
		$content ="<style>.box1{ width:300px;margin:20px;padding:10px;height:200px;position:relative;display:inline-block;
                   border:1pxsolid#ccc;-webkit-box-shadow:0px3px30pxrgba(0,0,0,0.1)inset;-webkit-border-bottom-right-radius:6px50px;}
                   h1{font-size:20px;font-weight:bold;text-align:center;margin-top:5px;text-shadow:1px1px3pxrgba(0,0,0,0.3);
                   line-height:150px;font-size:50px;color:#4A4A4A;}
                   </style><divclass='box1'><h1>".$code."</h1></div>";
        return $content;
	}
}
