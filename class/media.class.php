<?php

class Image {
    
    var $file;
    var $image_width;
    var $image_height;
    var $width;
    var $height;
    var $ext;
    var $types = array('','gif','jpeg','png','swf');
    var $quality = 80;
    var $top = 0;
    var $left = 0;
    var $crop = false;
    var $type;
	
    /*===============================================*/
	public function maxFileSize(){
		$max_upload = (int)(ini_get('upload_max_filesize'));
		$max_post = (int)(ini_get('post_max_size'));
		$memory_limit = (int)(ini_get('memory_limit'));
		$upload_mb = min($max_upload, $max_post, $memory_limit);
		$upload_mb = ($upload_mb*1024)*1024;
		return $upload_mb;	
	}
	
	public function upload($post_file,$path,$newName){
		//--
		$files = $_FILES[$post_file];
		//
		if(isset($files['tmp_name']) && ($files['error'] == UPLOAD_ERR_OK))
        {
            
			if($files['size'] < $this->maxFileSize()){
				
				$tmp_name = $files['tmp_name'];
				$name = $files['name'];
				$error = $files['error'];
				$poids = $files['size'];
				$type = $files["type"];
				//
				if(isset($newName)){
					if($newName!=""){
						require('typemime.class.php');
						$mime = new typemime();
						$ext = $mime->typeMimeToExtension($type);								
						$name = $newName.".".$ext;
						
					}else{
						$name = $this->cleanName($name);
					}
				}else{
					$name = $this->cleanName($name);
				}
				//
				if($path!=""){
					if(!file_exists($path)){
						$this->createPath($path);
					}
					$path = $this->cleanPath($path);
				}
				//				
				if(move_uploaded_file($tmp_name,$path."/".$name)){
					$this->name = $name;
					return true;
				}
				
			
				
			}else{
				echo "<script>alert('Fichier trop lourd');</script>";
			}
		}
		//---
	}
	
	/*===============================================*/
	
    public function Image($name='') {
        $this->file = $name;
        $info = getimagesize($name);
        $this->image_width = $info[0];
        $this->image_height = $info[1];
        $this->type = $this->types[$info[2]];
        $info = pathinfo($name);
        $this->dir = $info['dirname'];
        $this->name = str_replace('.'.$info['extension'], '', $info['basename']);
        $this->ext = $info['extension'];
    }
	
	public function getType(){
		return $this->type;
	}
	public function limiteFormat() {
		$type = $this->getType();
		$type = strtolower($type);
		if($type=='jpg' || $type=='jpeg' || $type=='png' || $type=='gif'){
			return true;
		}else{
			return false;	
		}
	}
	public function createPath($string){
		mkdir($string);	
	}
	public function cleanPath($string){
		$string = str_replace('/','',$string);
		$string = str_replace('..','../',$string);
		return $string;
	}
	public function stripAccents($string){
		return strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	}
	public function stripSpace($string){
		return str_replace(' ','_',$string);
	}
	public function stripQuote($string){
		return str_replace("'",'-',$string);
	}
	public function cleanName($n)  
	{  
		
		$arrSearch =  Array ("é","è","ë","ê","à","ä","â","ù","ü","û","ö","ô","ï","î"," ","Ï","ç","É","È","Ë","Û","'");
		$arrReplace =  Array ("e","e","e","e","a","a","a","u","u","u","o","o","i","i","_","i","c","e","e","e","u","-");
		$newtext = str_replace($arrSearch, $arrReplace, $n);
		return $newtext;
		
	
	}
    
    function dir($dir='') {
        if(!$dir) return $this->dir;
        $this->dir = $dir;
    }
    
    function name($name='') {
        if(!$name) return $this->name;
        $this->name = $name;
    }
    
    function width($width='') {
        $this->width = $width;
    }
    
    function height($height='') {
        $this->height = $height;
    }
    
    /*function resize($percentage=50) {
        if($this->crop) {
            $this->crop = false;
            $this->width = round($this->width*($percentage/100));
            $this->height = round($this->height*($percentage/100));
            $this->image_width = round($this->width/($percentage/100));
            $this->image_height = round($this->height/($percentage/100));
        } else {
            $this->width = round($this->image_width*($percentage/100));
            $this->height = round($this->image_height*($percentage/100));
        }
        
    }*/
    function resize($w,$h) {
        
		$ratio_orig = $this->image_width/$this->image_height;
		
		if ($w/$h > $ratio_orig) {
		   $w = $h*$ratio_orig;
		} else {
		   $h = $w/$ratio_orig;
		}
		
		$this->width = round($w);
		$this->height = round($h);
       
        
    }
    function crop($top=0, $left=0) {
        $this->crop = true;
        $this->top = $top;
        $this->left = $left;
    }
    
    function quality($quality=80) {
        $this->quality = $quality;
    }
    
    function show() {
        $this->save(true);
    }
    
    function save($show=false) {

        if($show){
			 @header('Content-Type: image/'.$this->type);	 
		}
        if(!$this->width && !$this->height) {
			
            $this->width = $this->image_width;
            $this->height = $this->image_height;
			
        } elseif (is_numeric($this->width) && empty($this->height)) {
			
            $this->height = round($this->width/($this->image_width/$this->image_height));
			
        } elseif (is_numeric($this->height) && empty($this->width)) {
			
            $this->width = round($this->height/($this->image_height/$this->image_width));
			
        } else {
            if($this->width<=$this->height) {
                $height = round($this->width/($this->image_width/$this->image_height));
                if($height!=$this->height) {
                    $percentage = ($this->image_height*100)/$height;
                    $this->image_height = round($this->height*($percentage/100));
                }
            } else {
                $width = round($this->height/($this->image_height/$this->image_width));
                if($width!=$this->width) {
                    $percentage = ($this->image_width*100)/$width;
                    $this->image_width = round($this->width*($percentage/100));
                }
            }
        }
        
        /*if($this->crop) {
            $this->image_width = $this->width;
            $this->image_height = $this->height;
        }*/
		if($this->type=='jpg') $image = imagecreatefromjpeg($this->file);
        if($this->type=='jpeg') $image = imagecreatefromjpeg($this->file);
        if($this->type=='png') $image = imagecreatefrompng($this->file);
        if($this->type=='gif') $image = imagecreatefromgif($this->file);
        
        $new_image = imagecreatetruecolor($this->width, $this->height);
        imagecopyresampled($new_image, $image, 0, 0, $this->top, $this->left, $this->width, $this->height, $this->image_width, $this->image_height);
        
        $name = $show ? null: $this->dir.DIRECTORY_SEPARATOR.$this->name.'.'.$this->ext;
        if($this->type=='jpeg') imagejpeg($new_image, $name, $this->quality);
        if($this->type=='png') imagepng($new_image, $name);
        if($this->type=='gif') imagegif($new_image, $name);
        
        imagedestroy($image); 
        imagedestroy($new_image);
		
		$this->name .=".".$this->ext; 
        
    }
	
	
    
}

?>