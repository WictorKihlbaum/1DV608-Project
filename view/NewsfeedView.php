<?php

class NewsfeedView {
    
	private static $numberOfNews = "NewsfeedView::NumberOfNews";
    private $newsfeed = "";
	private $number = 5;
	
	
	public function response() {
	
		return '
			<h1>Newsfeed</h1>
			
			'. $this -> renderDropDownList() .'
			'. $this -> getNewsFeed() .'
		';	
	}
    
    public function getNewsFeed() {
			
        return $this -> newsfeed;
    }
    
    private function setNewsfeed($newsfeed) {
        
        $this -> newsfeed = $newsfeed;
    }
	
	public function renderRSSFeed($feed) {
        
        $newsfeed = "";
		$limit = $this -> getLimitOfNews();
        
        for ($x = 0; $x < $limit; $x++) {
            
        	//$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']); Need?
			$title = $feed[$x]['title'];
        	$link = $feed[$x]['link'];
        	$description = $feed[$x]['desc'];
        	$date = date('l F d, Y', strtotime($feed[$x]['date']));
        	//$image = $feed[$x]['image'];
        	
        	$newsfeed .= '<div class="feedContent"><p><strong><a href="'. $link .' title="'. $title .'">'. $title .'</a></strong><br />' .
        	'<small>Posted on '. $date .'</small></p>'.
        	'<p>'. $description .'</p></div>';
        	
        	//'<img src="'.$image.'">' . 
        	// ^Put this before the 'p'-tag above.
        }
		
        $this -> setNewsfeed($newsfeed);
	}
	
	private function renderDropDownList() {
		
		return '
			Number of news per view: '." ".'
			
			
				<select id="'.self::$numberOfNews.'" name="'.self::$numberOfNews.'">
					<option value="'.$this->number.'">5</option>
					<option value="10">10</option>
					<option value="15">15</option>
				</select>
				
			</form>
		';
	}
	
	private function getLimitOfNews() {
		
		if (isset($_POST[self::$numberOfNews]))    
		{    
			return $_POST[self::$numberOfNews];     
		}    
		
		return 1;
	}
    
}