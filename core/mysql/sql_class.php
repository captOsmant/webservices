<?php

	class sqlConnect{
		
		private $hostname;
		private  $username;
		private  $password;
		private  $mainDB;
		private  $DBsource;

		public function sqlConnect(){
			$this->hostname="localhost";
			$this->username="host1316886";
			$this->password="password";
			$this->mainDB = "host1316886";
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
					$tpl = explode("\$".$key, $tpl);
					for ($j=0; $j<count($tpl)-1; $j++){
						$tpl[$j].=$value;
					}					
					$tpl = implode($tpl);
				}
				$response.= $tpl;	
			}
			return $response;
		}

		public function getTables(){
			return explode(" ", trim($this->fetch_array("SHOW TABLES", "$0 ")));
			

		}

	}
?>