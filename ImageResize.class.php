<?php 

/**
 * 动态缩放图片
 * @author ruansheng
 */
class ImageResize {
	
	/**
	 * 图片资源
	 */
	private $thumb;
	 
	/**
	 * 新宽度
	 * @var int
	 */
	private $newWidth=200;
	
	/**
	 * 新高度
	 * @var int
	 */
	private $newHeight=200;
	
	/**
	 * 缩放百分比
	 */
	private $percent=0.5;
	
	/**
	 * 模式
	 * @var int
	 */
	private $mode=1;
	
	/**
	 * 不存在提示
	 * @var string
	 */
	private $notExistsMsg='iamge not exists';
	
	/**
	 * 加载失败提示
	 * @var string
	 */
	private $loadFailMsg='image load fail';
	
	/**
	 * 构造函数
	 * @param array $options
	 */
	public function __construct($options=array()){
		$this->mode=$options['mode'];
		if($options['mode']==1){ //等比缩放
			if($options['percent']!=0){
				$this->percent=$options['percent'];
			}
		}else if($options['mode']==2){  // 宽度等比 高度自动
			if($options['newWidth']!=0){
				$this->newWidth=$options['newWidth'];
			}
		}else if($options['mode']==3){ //  高度等比  宽度自动
			if($options['newHeight']!=0){
				$this->newHeight=$options['newHeight'];
			}
		}else if($options['mode']==4){ // 自定义 宽高
			if($options['newWidth']!=0){
				$this->newWidth=$options['newWidth'];
			}
			if($options['newHeight']!=0){
				$this->newHeight=$options['newHeight'];
			}
		}
	}
	
	/**
	 * 动态输出图片
	 * @param string $filePath
	 */
	public function outPutImage($filePath){
		header('Content-Type: image/jpeg;');
		if(!file_exists($filePath)){
			$thumb  = imagecreatetruecolor($this->newWidth,$this->newHeight);
			$bgc = imagecolorallocate($thumb, 153, 102, 204);
			$tc  = imagecolorallocate($thumb, 0, 0, 0);
			
			imagefilledrectangle($thumb, 0, 0, $this->newWidth, $this->newHeight, $bgc);
			imagestring($thumb, 1, 5, $this->newHeight/2,$this->notExistsMsg, $tc);
		}else{
			$thumb = @imagecreatefromjpeg($filePath);
			if(!$thumb){
				$im  = imagecreatetruecolor($this->newWidth,$this->newHeight);
				$bgc = imagecolorallocate($thumb, 153, 102, 204);
				$tc  = imagecolorallocate($thumb, 0, 0, 0);
				imagefilledrectangle($thumb, 0, 0, $this->newWidth, $this->newHeight, $bgc);
				imagestring($thumb, 1, 5, $this->newHeight/2,$this->loadFailMsg, $tc);
			}else{
				list($width,$height)=getimagesize($filePath);
				$this->_getNewImageWH($width,$height);
				$source = imagecreatetruecolor($this->newWidth,$this->newHeight);
				imagecopyresized($source, $thumb, 0, 0, 0, 0, $this->newWidth,$this->newHeight, $width, $height);
				imagejpeg($source);
			}
		}
		$this->thumb=$thumb;
	}
	
	/**
	 * 计算新图片的宽高
	 * @param int $width
	 * @param int $height
	 */
	private function _getNewImageWH($width,$height){
		if($this->mode==1){
			$this->newWidth=$width*$this->percent;
			$this->newHeight=$height*$this->percent;
		}else if($this->mode==2){
			if($this->newWidth<$width){
				$percent=($width-$this->newWidth)/$width;
			}else{
				$percent=$this->newWidth/$width;
			}
			$this->newWidth=$width*$percent;
			$this->newHeight=$height*$percent;
		}else if($this->mode==3){
			if($this->newHeight<$height){
				$percent=($height-$this->newHeight)/$height;
			}else{
				$percent=$this->newHeight/$height;
			}
			$this->newWidth=$width*$percent;
			$this->newHeight=$height*$percent;
		}else if($this->mode==4){
		}
	}
	
	/**
	 * 析构函数
	 */
	public function __destruct(){
		if($this->thumb){
			imagejpeg($this->thumb);
			imagedestroy($this->thumb);
		}
	}
}


//example:

$options=array(
		'mode'=>4,
		'percent'=>0.5,
);
$filePath='3.jpg';

$Image=new ImageResize($options);
$Image->outPutImage($filePath);

