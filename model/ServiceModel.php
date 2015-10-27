<?php

class ServiceModel {

	private $userDAL;
	private $rssDAL;
	
	
	public function __constructor($userDAL, $rssDAL) {
		
		$this -> userDAL = new UserDAL();
		$this -> rssDAL = new RssDAL();
	}
	
	public function getRegisteredUsers() {
		
		if ($this -> userDAL == null) {
			
			$this -> userDAL = new UserDAL();
		} 	
		
		return $this -> userDAL -> getRegisteredUsers();
	}
	
	public function getRssCache() {
		
		if ($this -> rssDAL == null) {
			
			$this -> rssDAL = new RssDAL();
		}
		
		return $this -> rssDAL -> getRss();
	}
	
}