<?php

class RssDAL {
	
	// Public Database.
	private $host = 'eu-cdbr-azure-north-d.cloudapp.net';
	private $port = 3306;
	private $socket = '';
	private $user = 'bd59d7069aef53';
	private $password = '6d5d241f';
	private $dbname = 'acsm_9268280c21a7845';
	
	private $rssCache = array();
	
	
	private function connectToServerAndFetchRSS() {
		
		$con = new mysqli($this -> host, $this -> user, $this -> password, $this -> dbname, $this -> port, $this -> socket)
			or die ('Could not connect to the database server' . mysqli_connect_error());
			
		$query = 'SELECT SiteName, RssLink FROM rss';
		
		if ($stmt = $con -> prepare($query)) {
			
			$stmt -> execute();
			$stmt -> bind_result($siteName, $rssLink);
			
			while ($stmt -> fetch()) {
				// Save all DB-content to a "cache-array".
				$rss = new RssModel($siteName, $rssLink);
				$this -> rssCache[] = $rss;
    		}
				
			$stmt -> close();
		}
		
		$con -> close();
	}
	
	public function getRss() {
		
		if ($this -> rssCache == null ||
			empty($this -> rssCache)) {
				
			$this -> connectToServerAndFetchRSS();
		}
	
		return $this -> rssCache;	
	}
}