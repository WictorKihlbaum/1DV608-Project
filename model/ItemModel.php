<?php

class ItemModel {

	private $title;
	private $description;
	private $link;
	private $pubDate;
	private $imgUrl;
	private $videoLink;
	
	
	public function __construct($title, $description, $link, $pubDate, $imgUrl, $videoLink) {
	
		$this -> title = $title;
		$this -> description = $description;
		$this -> link = $link;
		$this -> pubDate = $pubDate;
		$this -> imgUrl = $imgUrl;
		$this -> videoLink = $videoLink;
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
	
	public function getVideoLink() {
	
		return $this -> videoLink;	
	}
}