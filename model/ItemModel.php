<?php

class ItemModel {

	private $title;
	private $description;
	private $link;
	private $pubDate;
	private $imgUrl;
	
	
	public function __construct($title, $description, $link, $pubDate, $imgUrl) {
	
		$this -> title = $title;
		$this -> description = $description;
		$this -> link = $link;
		$this -> pubDate = $pubDate;
		$this -> imgUrl = $imgUrl;
	}
	
	public function getTitle() {
	
		return $this -> title;	
	}
	
	public function getDescription() {
	
		return $this -> description;	
	}
	
	public function getLink() {
	
		return $this -> link;	
	}
	
	public function getPubDate() {
	
		return $this -> pubDate;	
	}
	
	public function getImgUrl() {
	
		return $this -> imgUrl;	
	}
	
}