<?php
class texte{
	
	
	public function cutString($string,$limite,$terminaison="..."){
		//
		if(strlen($string) <= $limite)
		{
			return $string;
		}
		$str = substr($string,0,$limite-strlen($terminaison)+1);
		if(strrpos($str,' ')){
			return substr($str,0,strrpos($str,' ')).$terminaison;
		}else{
			return $str.$terminaison;
		}
	}
	
	public function clean($badstring){
		$pattern = Array("é", "è", "ê", "ç", "à", "â", "î", "ï", "ù", "ô","'");
		$rep_pat = Array("e", "e", "e", "c", "a", "a", "i", "i", "u", "o","-");
		$cleaned= str_replace($pattern, $rep_pat, $badstring);
		$file_bad = array("@-@", "@_@", "@[^A-Za-z0-9_ ]@", "@ +@");
		$file_good = array(" ", " ", "", " ");
		$cleaned= preg_replace($file_bad, $file_good, $cleaned);
		$cleaned= str_replace(" ", "-", trim($cleaned));
		return $cleaned;
	}
	
	public function cleanFile($badstring){
		
		$filename = explode('.', $badstring);
		$this->filenameext = $filename[count($filename)-1];
		unset($filename[count($filename)-1]);
		$filename = implode('.', $filename);
		$filename = $this->clean($filename);
		$filename = $filename.'.'.$this->filenameext;
		return $filename;
		
	}
	
	public function getExtension(){
		return 	$this->filenameext;
	}
}
?>