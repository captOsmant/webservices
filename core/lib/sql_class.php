<?php

	class SQLConnection{

		private  $hostname;
		private  $username;
		private  $password;
		private  $mainDB;
		private  $DBsource;

		public function __construct($hostname = "", $username = "", $password = "", $mainDB = ""){
		
			$data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/core/lib/mysql_data");
			$data = explode('[|]',$data);	
			if ($mainDB=="") $mainDB=$data[3];
			if ($password=="") $password=$data[2];
			if ($username=="") $username=$data[1];
			if ($hostname=="") $hostname=$data[0];
		
			$this->hostname= $hostname;
			$this->username= $username;
			$this->password= $password;
			$this->mainDB = $mainDB;
			$this->DBSource = mysql_connect($this->hostname, $this->username, $this->password);
			mysql_select_db($this->mainDB, $this->DBSource);
			
		}
		
		
		
		public function DB(){
			return $this->DBSource;
		}
	
		public function query($q){
			return mysql_query($q);
		}

		public function fetch_array($q, $template){
			$res = $this->query($q);
			$response="";
		
			if (!$res) return "";
			while ($T = mysql_fetch_array($res)){
				
				$tpl = $template;
				for ($i=0; $i<count($T); $i++){
					$tpl = explode("$".$i, $tpl);
					
					for ($j=0; $j<count($tpl)-1; $j++){
						$tpl[$j].=$T[$i];
					}					
					$tpl = implode($tpl);	
				}
				$response.= $tpl;			

			}
			return $response;
		}

		public function fetch_assoc($q, $template){
			$res = $this->query($q);
			$response="";			
			while ($T = mysql_fetch_assoc($res)){				
				$tpl = $template;
				foreach ($T as $key => $value){
					$tpl = explode("$".$key, $tpl);
					for ($j=0; $j<count($tpl)-1; $j++){
						$tpl[$j].=$value;
					}					
					$tpl = implode($tpl);
				}
				$response.= $tpl;	
			}
			return $response;
		}

		public function getAssocArray($Q){
			$res = $this->query($Q);
			$result = array();
			while($T = mysql_fetch_assoc($res)) array_push($result, $T);
			return $result;
		}
		
		
		public function getArray($Q){
			$res = $this->query($Q);
			$result = array();
			while($T = mysql_fetch_array($res)) array_push($result, $T);
			return $result;
		}
		
		
		public function getTables(){
			return explode(" ", trim($this->fetch_array("SHOW TABLES", "$0 ")));
			

		}

		

		public function getCatalog($data){
			
			
			$RES = array();
			
			// Returns all of the children of element with id $id and on the nesting level $index

			function catalog($index, $id, $data,$context){
				

				$result= array();
				$res = mysql_query("SELECT * FROM ".$data[$index]." WHERE id=".$id);
				$T = mysql_fetch_assoc($res);
				$result[0]=$T;
				
				if (!$data[$index+1]) {return 0;}

				if (!$data[$index+2]){

					$res = mysql_query("SELECT * FROM ".$data[$index+1]." WHERE parent=".$id);
					while ($T = mysql_fetch_assoc($res)){
						$result[count($result)] = $T;
					}
					return $result;
				}

				$res = mysql_query("SELECT * FROM ".$data[$index+1]." WHERE parent=".$id);
				while ($T = mysql_fetch_array($res)){
					$idn = $T[0];
					$result[count($result)]=catalog($index+1,$idn,$data,$context);
			
				}
				return $result;
				
			}
			
			$count = $this->fetch_array("SELECT COUNT(*) FROM ".$data[0],"$0");
			
			
				$res = mysql_query("SELECT id FROM ".$data[0]);

				while ($T = mysql_fetch_array($res)){
					$id = $T[0];
					$RES[count($RES)]=catalog(0,$id,$data,$this);
				}
			
			return $RES;
		}



		public function getCatalogR($data){
			
			
			$RES = array();
			
			// Returns all of the children of element with id $id and on the nesting level $index

			function catalog($index, $id, $data,$context){
				

				$result= array();
				$res = mysql_query("SELECT * FROM ".$data[$index]." WHERE id=".$id);
				$T = mysql_fetch_assoc($res);
				$result[0]=$T;
				
				if (!$data[$index+1]) {return 0;}

				if (!$data[$index+2]){

					$res = mysql_query("SELECT * FROM ".$data[$index+1]." WHERE parent=".$id);
					while ($T = mysql_fetch_assoc($res)){
						$result[count($result)] = $T;
					}
					return $result;
				}

				$res = mysql_query("SELECT * FROM ".$data[$index+1]." WHERE parent=".$id);
				while ($T = mysql_fetch_array($res)){
					$idn = $T[0];
					$result[count($result)]=catalog($index+1,$idn,$data,$context);
			
				}
				return $result;
				
			}
			
			$count = $this->fetch_array("SELECT COUNT(*) FROM ".$data[0],"$0");
			
			
				$res = mysql_query("SELECT id FROM ".$data[0]);

				while ($T = mysql_fetch_array($res)){
					$id = $T[0];
					$RES[count($RES)]=catalog(0,$id,$data,$this);
				}
			
			return $RES;
		}
	}
?>