<?php 

/**
 * 裁剪图片
 * @author ruansheng
 */
class ImageCut {
	
	/**
	 * 图片尺寸
	 * @var array
	 */
	private static $size=array(
		30,50,100,200
	);
	
	/**
	 * 执行裁剪图片
	 */
	public static function cut($imageFileName,$savePath,$size=array()){
		
	}
	
	/**
	 * 裁剪头像图片：生成各种尺寸的图片
	 */
	protected function thumbAvatar($path,$fileName,$fileType){
		$file_path=$path.'/'.$fileName.$fileType;
		//生成4张不同尺寸的缩略图
		$filePath_30=$path.'/'.$fileName.'_30_30'.$fileType;
		$filePath_50=$path.'/'.$fileName.'_50_50'.$fileType;
		$filePath_100=$path.'/'.$fileName.'_100_100'.$fileType;
		$filePath_200=$path.'/'.$fileName.'_200_200'.$fileType;
	
		$this->resizeImage($file_path,30, $filePath_30); //生成30*30的图片
		$this->resizeImage($file_path,50, $filePath_50); //生成50*50的图片
		$this->resizeImage($file_path,100, $filePath_100); //生成100*100的图片
		$this->resizeImage($file_path,200, $filePath_200); //生成200*200的图片
	}
	
	/**
	 * 生成不同尺寸的图片
	 * @param string $imgurl    图片url
	 * @param string $maxwidth  缩放宽度
	 * @param string $name      缩放名称全路径
	 */
	protected function resizeImage($imurl,$maxwidth,$name)
	{
		if(strstr($imurl,".jpg")){
			$im1=imagecreatefromjpeg($imurl);
			$im=$im1;
		}else if(strstr($imurl,".png")){
			$im2=imagecreatefrompng ($imurl);
			$im=$im2;
		}else if(strstr($imurl,".gif")){
			$im3=imagecreatefromgif($imurl);
			$im=$im3;
		}
	
		$pic_width = imagesx($im);
		$pic_height = imagesy($im);
		if($maxwidth && $pic_width > $maxwidth)
		{
			if($maxwidth && $pic_width>$maxwidth)
			{
				$widthratio = $maxwidth/$pic_width;
				$resizewidth_tag = true;
			}
	
			$resizeheight_tag=false;
			if($resizewidth_tag && !$resizeheight_tag)
				$ratio = $widthratio;
	
			$newwidth = $maxwidth;
			$newheight = $pic_height * $ratio;
			if(function_exists("imagecopyresampled"))
			{
				$newim = imagecreatetruecolor($newwidth,$newheight);
				imagecopyresampled($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
			}
			else
			{
				$newim = imagecreate($newwidth,$newheight);
				imagecopyresized($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
			}
			// $name = $name.$filetype;
			imagejpeg($newim,$name);
			imagedestroy($newim);
		}
		else
		{
			// $name = $name.$filetype;
			imagejpeg($im,$name);
		}
	}
} 

