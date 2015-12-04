<?php

class RssDAL {
	
	private $rssCache = array();
	
	
	private function connectToServerAndFetchRSS() {
		
		$databaseInfo = new DatabaseInfoModel();
	
		$con = new mysqli(
			$databaseInfo -> getHost(), 
			$databaseInfo -> getUser(), 
			$databaseInfo -> getPassword(), 
			$databaseInfo -> getDatabaseName(), 
			$databaseInfo -> getPort(), 
			$databaseInfo -> getSocket()
		) 
		or die ('Could not connect to the database server' . mysqli_connect_error());
		
		if ($stmt = $con -> prepare($databaseInfo -> getRSSFeedsStoredProcedure())) {
			
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