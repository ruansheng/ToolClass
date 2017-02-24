<?php 
date_default_timezone_set('Asia/ShangHai');
include('./phpmailer/Smtp.class.php');
include('./phpmailer/PHPMailer.class.php');
/**
 * Mail 服务
 * @author ruansheng
 */
class MailService {
	
	/**
	 * Mail句柄
	 * @var mixed
	 */
	private static $handler;
	
	/**
	 * 邮件服务器Host
	 * @var unknown
	 */
	private static $mailHost="smtp.qq.com";
	
	/**
	 * 邮件服务器Host
	 * @var unknown
	 */
	private static $mailPort= 25;
	
	/**
	 * 发件人账号
	 */
	private static $userInfo=array(
			'user_name'=>"ruansheng",
			'user'=>"ruansheng@qwbcg.com",
			'password'=>'rs19900918'
	);
	
	/**
	 * 构造方法
	 */
	public static function newInstance(){
		self::$handler=new PHPMailer();
		// 设置PHPMailer使用SMTP服务器发送Email
		self::$handler->IsSMTP();
		// 设置邮件的字符编码，若不指定，则为'UTF-8'
		self::$handler->CharSet='UTF-8';
	}
	
	/**
	* 发送文本邮件
	*/
	public static function sendTextMail($address,$title,$message){
		$flag=self::_sendMail($address, $title, $message);
		return $flag;
	}
	
	/**
	 * 发送HTML邮件
	 */
	public static function sendHtmlMail($address,$title,$message){
		self::$handler->IsHTML(true);  // send as HTML
		self::$handler->AltBody ="text/html";
		$flag=self::_sendMail($address, $title, $message);
		return $flag;
	}
	
	/**
	 * 发送邮件
	 * @param mixed $address
	 * @param string $title
	 * @param string $message
	 * @return boolean
	 */
	private function _sendMail($address,$title,$message){
		self::_addAddress($address);
		// 设置邮件正文
		self::$handler->Body=$message;
		// 设置邮件头的From字段。
		self::$handler->From=self::$userInfo['user'];
		// 设置发件人名字
		self::$handler->FromName=-self::$userInfo['user_name'];
		// 设置邮件标题
		self::$handler->Subject=$title;
		// 设置SMTP服务器。
		self::$handler->Host=self::$mailHost;
		// 设置SMTP服务器端口。
		self::$handler->Port=self::$mailPort;
		// 设置为“需要验证”
		self::$handler->SMTPAuth=true;
		// 设置用户名和密码。
		self::$handler->Username=self::$userInfo['user'];
		self::$handler->Password=self::$userInfo['password'];
		// 发送邮件。
		return self::$handler->Send();
	}
	
	/**
	 *  添加收件人地址
	 * @param mixed $address
	 */
	private function _addAddress($address){
		// 添加收件人地址，可以多次使用来添加多个收件人
		if(is_array($address)){
			foreach($address as $v){
				self::$handler->AddAddress($v);
			}
		}else{
			self::$handler->AddAddress($address);
		}
	}
	
}
