<?php
class sql{
	
	public $query;
	public $fetch;
	
	public function setQuery($string){
		$this->query = $string;		
	}
	public function select($table,$where="",$champs="",$option=""){
		
		if(!isset($champs) || $champs==""){
			$champs = "*";			
		}
		if(!isset($option)){
			$option = "";			
		}
		if(isset($where) && $where!=""){
			$where = "WHERE ".$where;
		}else{
			$where = "";
		}
		
		$this->query = "SELECT ".$champs." FROM ".$table." ".$where." ".$option;
	}
	
	public function getNumRows(){
		return $this->numRows;
	}
	
	public function result(){
		return @mysql_fetch_array($this->query);
	}

	public function insert($table,$champs,$values){
		
		$champs = implode("`,`",$champs);
		$champs = "`".$champs."`";
		
		$values = implode("','",$values);
		$values = "'".$values."'";
		
		$this->query = "INSERT INTO ".$table." (".$champs.") VALUES (".$values.")";
	}
	
	public function update($table,$champs,$values,$where=""){
		
		$requete = "UPDATE ";
		$requete .= $table;
		
		for($i=0;$i<count($champs);$i++){
			$condition .= $champs[$i]."='".$values[$i]."', ";
		}
		
		$requete .= " SET ".substr($condition,0,strlen($condition)-2);
		
		if(isset($where) && $where!=""){
			$where = " WHERE ".$where;
		}else{
			$where = "";
		}
		
		$requete .=$where;
		
		$this->query=$requete;
	}
	
	public function delete($table,$where=""){
		
		if(isset($where)){
			$where = "WHERE ".$where;
		}else{
			$where = "";
		}
		$this->query = "DELETE FROM ".$table." ".$where;
	}
	
	public function execute(){
		$this->query = mysql_query($this->query);
		@$this->numRows = mysql_num_rows($this->query);
		if($this->query){
			return true;	
		}else{
			return false;
		}
	}
	
	public function getQuery(){
		return $this->query;	
	}
	
	public function nextID($table){
		$query = "SHOW TABLE STATUS WHERE Name =  '".$table."'";
		$result = mysql_query($query) or SQL_Error($query, mysql_error(), __LINE__);
		//On parcoure les ligne de resultats
		$infos_tables = mysql_fetch_array($result);
		return $infos_tables[10];
	}
	
	public function insertID(){
		return mysql_insert_id();
	}
}
?>