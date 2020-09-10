<?php
	class videoPlatform{
		//
		public function youtube($str){
			$start="=";
			$pos_depart = strpos($str,$start)+strlen($start);
			$this->ID = substr($str,$pos_depart,11);
			return $this->ID;
		}
		//
		public function dailymotion($str){
			
			$url = explode('/',$str);
			$id = explode('_',end($url));
			$this->ID = $id[0];
			
			return $this->ID;
		}
		//
		public function vimeo($str){
			$url = explode('/',$str);
			$this->ID = end($url);
			return $this->ID;
		}
		public function getID(){
			return $this->ID;
		}
		public function getPlatform(){
			return $this->platforme;
		}
		//
		public function extractPlatform($str){
			
			if(strpos($str,"youtube")){
				$this->platforme = "youtube";
			}
			if(strpos($str,"dailymotion")){
				$this->platforme = "dailymotion";
			}
			if(strpos($str,"vimeo")){
				$this->platforme = "vimeo";
			}
			return $this->platforme;
			
		}
		//
		public function share($str,$width,$height){
			$this->extractPlatform($str);
			if($this->platforme=='youtube'){
				$this->youtube($str);
				return '<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$this->ID.'?rel=0" frameborder="0" allowfullscreen></iframe>';
			}
			if($this->platforme=='dailymotion'){
				$this->dailymotion($str);
				return '<iframe frameborder="0" width="'.$width.'" height="'.$height.'" src="http://www.dailymotion.com/embed/video/'.$this->ID.'"></iframe>';
			}
			if($this->platforme=='vimeo'){
				$this->vimeo($str);
				return '<iframe src="http://player.vimeo.com/video/'.$this->ID.'?title=0&amp;byline=0&amp;portrait=0" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
			}				
		}
		
		
		
	}
?>