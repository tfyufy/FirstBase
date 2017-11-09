<?php

namespace App\Model;

require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer as mailer;

class emailClass{
//邮件发送的方法phpmailer
	public function sendMail($to,$nickname,$title,$content){
        $mail = new mailer\PHPMailer();
        $mail->SMTPDebug = 0;//debug
        $mail->isSMTP();
        $mail->SMTPAuth=true;
		$mailconfig = \PhalApi\DI()->config->get('app.stmpconfig');
        $mail->Host = $mailconfig['host'];
        $mail->SMTPSecure =$mailconfig['secure'];
        $mail->Port = 465;
        $mail->CharSet = 'UTF-8';
        $mail->FromName = 'TFYUFY';
        $mail->Username =$mailconfig['username'];
        $mail->Password = $mailconfig['password'];
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