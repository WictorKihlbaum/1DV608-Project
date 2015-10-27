<?php

class ServiceModel {

	private $userDAL;
	private $rssDAL;
	
	
	public function __constructor($userDAL, $rssDAL) {
		
		$this -> userDAL = $userDAL;
		$this -> rssDAL = $rssDAL;
	}
	
	public function getRegisteredUsers() {
	
		return $this -> userDAL -> getRegisteredUsers(); 	
	}
	
	public function getRssCache() {
		
		return $this -> rssDAL -> getRss();	
	}
	
}