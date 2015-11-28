<?php
class Match
{
	private $id = 0;
	private $title = "";
	private $content = "";
	private $date = "";
	private $tags = array();
	private $matchPoint = 0;

	function __construct($id, $title, $content, $date, $tags)
	{
		$this->setId($id);
		$this->setTitle($title);
		$this->setContent($content);
		$this->setDate($date);
		$this->setTags($tags);
	}

	public function getId()
	{
		return $this->id;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getTags()
	{
		return $this->tags;
	}

	public function getMatchPoint()
	{
		return $this->matchPoint;
	}

	public function setId($id)
	{
		if(isset($id)) $this->id = $id;
	}

	public function setTitle($title)
	{
		if(isset($title)) $this->title = $title;
	}

	public function setContent($content)
	{
		if(isset($content)) $this->content = $content;
	}

	public function setDate($date)
	{
		if(isset($date)) $this->date = $date;
	}

	public function setTags($tags)
	{
		if(isset($tags)) $this->tags = $tags;
	}

	public function setMatchPoint($key)
	{
		if(!isset($key)) return;

		for($j = 0; $j < count($key); $j++)
		{
			for($i = 0; $i < count($this->tags); $i++)
			{
				if(stripos($this->tags[$i], $key[$j]) !== FALSE)
					$this->matchPoint++;
			}

			$lastTitlePos = -1;
			$lastContentPos = -1;
			$loop = TRUE;

			while($loop)
			{
				if($lastTitlePos !== FALSE) $lastTitlePos = stripos($this->title, $key[$j], $lastTitlePos + 1);
				if($lastContentPos !== FALSE) $lastContentPos = stripos($this->content, $key[$j], $lastContentPos + 1);

				if($lastTitlePos === FALSE && $lastContentPos === FALSE) $loop = FALSE;
				if($lastTitlePos !== FALSE) $this->matchPoint++;
				if($lastContentPos !== FALSE) $this->matchPoint++;
			}
		}
	}
}

class Ramtin
{
	private static $DB_HOST = "localhost";
	private static $DB_NAME = "ramtin_data";
	private static $DB_USER = "root";
	private static $DB_PASS = "";
	public static $SORT_TYPE_1 = "best"; 		//For best matches
	public static $SORT_TYPE_2 = "recent"; 		//For most recent (DESC)
	public static $SORT_TYPE_3 = "old"; 		//For oldest (ASC)
	private static $RESULTS_PER_PAGE = 20;		//For showing results in each page (search.php)
	private static $TAGS_PER_PAGE = 10;			//For showing tags in each page (tag.php)
	private static $lastPage = 0;				//To be set after each search()
	private static $searchFlag = TRUE;			//True: success, False: invalid parameters
	private static $RESULTS_CHAR_LIMIT = 450;	//To limit the amount of characters that will be shown for each result followed by ellipsis

	private static function validateParam($param)
	{
		if(!isset($param)) return false;
		if(trim($param) == "") return false;

		return true;
	}

	private static function connect()
	{
		return new PDO('mysql:host=' . self::$DB_HOST . ';dbname=' . self::$DB_NAME . ';charset=utf8', self::$DB_USER, self::$DB_PASS);
	}

	private static function moveElement(&$array, $currentIndex, $newIndex)
	{
	    $temp = array_splice($array, $currentIndex, 1);
	    array_splice($array, $newIndex, 0, $temp);
	}

	private static function sortMatchesByPoints(&$matches)
	{
		for($i = 0; $i < count($matches) - 2; $i++)
		{
			$max = -1;
			$maxIndex = -1;

			//Find the element with maximum matchPoint
			for($j = $i; $j < count($matches) - 1; $j++)
			{
				if($matches[$j]->getMatchPoint() > $max)
				{
					$max = $matches[$j]->getMatchPoint();
					$maxIndex = $j;
				}
			}

			//Push the maximum element to the index after the previous pushed max (which is greater than this max)
			self::moveElement($matches, $maxIndex, $i);
		}
	}

	public static function search($key, $sortType, $pageNum)
	{
		if(!self::validateParam($key) || !self::validateParam($sortType) || !self::validateParam($pageNum)
			|| $pageNum < 1 || ($sortType != self::$SORT_TYPE_1 && $sortType != self::$SORT_TYPE_2 && $sortType != self::$SORT_TYPE_3))
		{
        	self::$searchFlag = FALSE;
        	return FALSE;
        }

		//Separating key to words
		$keys = explode(' ', $key);

		//Building SQL command
        $colEnum = array('tags', 'title', 'content');
        $sqlCommand = 'SELECT * FROM posts WHERE ';

        for($i = 0; $i < count($colEnum); $i++)
        {
            for($j = 0; $j < count($keys); $j++)
            {
                $sqlCommand .= $colEnum[$i] . ' LIKE "%' . $keys[$j] . '%" OR ';
            }
        }

        //Build order command
        $sortCommand = "";
        if($sortType == self::$SORT_TYPE_1) $sortCommand = "";
        if($sortType == self::$SORT_TYPE_2) $sortCommand = " ORDER BY date DESC";
        if($sortType == self::$SORT_TYPE_3) $sortCommand = " ORDER BY date ASC";

        $sqlCommand = substr($sqlCommand, 0, strlen($sqlCommand) - 4) . $sortCommand;

        //Connect to database
        $db = self::connect();

        //Get result
        $matches = array();
        $resultsCountStart = ($pageNum - 1) * (self::$RESULTS_PER_PAGE + 1);
        $resultsCountEnd = $resultsCountStart + self::$RESULTS_PER_PAGE;
        $resultsCount = 0;

        foreach($db->query($sqlCommand) as $row)
        {
        	$resultsCount++;

        	//Skip pushing in array if the index is not part of the selected portion (based on pageNum and RESULTS_PER_PAGE) only if sort method is not by best match
        	if($resultsCount < $resultsCountStart && $sortType != self::$SORT_TYPE_1) continue;
        	if($resultsCount > $resultsCountEnd && $sortType != self::$SORT_TYPE_1) break;

        	$match = new Match($row['id'], $row['title'], $row['content'], $row['date'], explode(',', $row['tags']));
        	$match->setContent(substr(preg_replace('/\r\n+/',' ', strip_tags($match->getContent())), 0, self::$RESULTS_CHAR_LIMIT) . (strlen($match->getContent()) > self::$RESULTS_CHAR_LIMIT?'...':''));
        	array_push($matches, $match);
        	if($sortType == self::$SORT_TYPE_1) $matches[count($matches) - 1]->setMatchPoint($keys);
        }

        self::$lastPage = intval(($resultsCount / self::$RESULTS_PER_PAGE) + ($resultsCount % self::$RESULTS_PER_PAGE > 0?1:0));

        if($pageNum > self::$lastPage && $resultsCount > 0)
        {
        	self::$searchFlag = FALSE;
        	return FALSE;
        }

        //If sort method is by best match, then all elements are pushed in array
        if($sortType == self::$SORT_TYPE_1)
        {
        	//Sort by matchPoint
        	self::sortMatchesByPoints($matches);
        	//Remove the unwanted portion of array based on pageNum and RESULTS_PER_PAGE
        	$matches = array_splice($matches, ($pageNum - 1) * self::$RESULTS_PER_PAGE, (($pageNum - 1) * self::$RESULTS_PER_PAGE) + self::$RESULTS_PER_PAGE);
        }

        //Close connection
        $db = null;

        self::$searchFlag = TRUE;

        return $matches;
	}

	public static function showSearchTitleGUI($resultsExist, $key)
	{
		if(!self::$searchFlag)
			return '<div class="filterTitle" style="margin-bottom: -30px;">Invalid search parameters!</div>';
		elseif($resultsExist)
			return '<div class="filterTitle">Showing results for \'' . $key . '\'</div>';
		else
			return '<div class="filterTitle">No results found for \'' . $key . '\'</div>
					<div class="defaultText" style="width: auto; margin-left: 80px; margin-right: 80px;">
						<ul>
							<li type="circle">Check for typos or try different keywords.</li>
							<li type="circle">If you find a post relevant to what you’re looking for, try searching for the tags attached to that post by either clicking on them or typing them in the search box.</li>
							<li type="circle">If none of the above instructions has worked, it may be possible that the post you’re looking for has been temporariliy or permanently removed.</li>
						</ul>
					</div>';
	}

	public static function showSearchSortGUI($key, $sort, $page)
	{
		$sortClass1 = 'sortBoxItem' . ($sort == self::$SORT_TYPE_1?' sortBoxItemSelected':' sortBoxItemNotSelected');
		$sortClass2 = 'sortBoxItem' . ($sort == self::$SORT_TYPE_2?' sortBoxItemSelected':' sortBoxItemNotSelected');
		$sortClass3 = 'sortBoxItem' . ($sort == self::$SORT_TYPE_3?' sortBoxItemSelected':' sortBoxItemNotSelected');

		$sortClick1 = $sort != self::$SORT_TYPE_1?'location.href=\'search.php?key='.$key.'&sort='.self::$SORT_TYPE_1.'&page='.$page.'\'':'';
		$sortClick2 = $sort != self::$SORT_TYPE_2?'location.href=\'search.php?key='.$key.'&sort='.self::$SORT_TYPE_2.'&page='.$page.'\'':'';
		$sortClick3 = $sort != self::$SORT_TYPE_3?'location.href=\'search.php?key='.$key.'&sort='.self::$SORT_TYPE_3.'&page='.$page.'\'':'';

		$GUI = '<div class="sortBoxContainer">
					<div class="sortBox">
						<div class="'.$sortClass1.'" onclick="'.$sortClick1.'">Best Match</div>
						<div class="'.$sortClass2.'" onclick="'.$sortClick2.'">Most Recent</div>
						<div class="'.$sortClass3.'" onclick="'.$sortClick3.'">Oldest</div>
					</div>
				</div>
				<div class="sortBoxSeparator"></div>';

		return $GUI;
	}

	public static function showSearchGUI($matches)
	{
		$GUI = "";

		for($i = 0; $i < count($matches); $i++)
		{
			$postLink = 'location.href=\'post.php?id=' . $matches[$i]->getId() . '\'';
			$GUI .= '<div class="searchResultContainer" onclick="' . 
			 $postLink . '"><div class="searchResultTitle noSelection">' . 
			 $matches[$i]->getTitle() . '</div><div class="searchResultContent noSelection">' . 
			 $matches[$i]->getContent() . '</div></div>' . ($i < count($matches) - 1?'<div class="searchResultSeparator"></div>':'');
		}

		return $GUI;
	}

	public static function showSearchPageNavigationGUI($page, $key, $sort)
	{
		$prevItem = ($page > 1?'<a href="search.php?key=' . $key . '&sort=' . $sort . '&page=' . (intval($page) - 1) . '">':'') . '< Prev' . ($page > 1?'</a>':'');
		$nextItem = ($page < self::$lastPage?'<a href="search.php?key=' . $key . '&sort=' . $sort . '&page=' . (intval($page) + 1) . '">':'') . 'Next >' . ($page < self::$lastPage?'</a>':'');
		$pageItem = 'Page ' . $page;

		$GUI = '<div class="pageNavigationContainer"><div class="pageNavigation noSelection">' .
		 '<div class="pageNavigationItem' . ($page > 1?' pointCursor':' defaultCursor') . '">' . $prevItem . '</div>' .
		 '<div class="pageNavigationItem defaultCursor" style="color: #383838;">' . $pageItem . '</div>' .
		 '<div class="pageNavigationItem' . ($page < self::$lastPage?' pointCursor':' defaultCursor') . '">' . $nextItem . '</div>' .
		 '</div></div>';

		return $GUI;
	}

	public static function showTags($tag, $sort, $page)
	{
		if(!self::validateParam($tag) || !self::validateParam($sort) || !self::validateParam($page) || strpos(trim($tag), ' ') != FALSE
		 || ($sort != self::$SORT_TYPE_2 && $sort != self::$SORT_TYPE_3))
			return '<div class="filterTitle" style="margin-bottom: -30px;">Invalid filter parameters!</div>';

		$GUI = '<div class="filterTitle">Filtering by tag \'' . $tag . '\'</div>';
		$GUI .= self::showTagSortGUI($tag, $sort, $page);

		$db = self::connect();

		$orderBy = ($sort == self::$SORT_TYPE_2?'DESC':'ASC');
		$tagCount = 0;
		$tagCountStart = ($page - 1) * (self::$TAGS_PER_PAGE + 1);
        $tagCountEnd = $tagCountStart + self::$TAGS_PER_PAGE;
        $sqlCommand = 'SELECT * FROM posts WHERE tags LIKE "%' . $tag . '%" ORDER BY date ' . $orderBy;
        $matches = array();

        //Read each row from posts table
        foreach($db->query($sqlCommand) as $row)
        {
        	$tagCount++;

			//Skip appending to GUI if the index is not part of the selected portion (based on page and TAGS_PER_PAGE)
        	if($tagCount < $tagCountStart) continue;
        	if($tagCount > $tagCountEnd) break;

            $match = new Match($row['id'], $row['title'], $row['content'], $row['date'], explode(',', $row['tags']));
        	$match->setContent(substr(preg_replace('/\r\n+/',' ', strip_tags($match->getContent())), 0, self::$RESULTS_CHAR_LIMIT) . (strlen($match->getContent()) > self::$RESULTS_CHAR_LIMIT?'...':''));
        	array_push($matches, $match);
        }

        self::$lastPage = intval(($tagCount / self::$TAGS_PER_PAGE) + ($tagCount % self::$TAGS_PER_PAGE > 0?1:0));

        if(intval($page) < 1 || intval($page) > self::$lastPage)
        	return '<div class="filterTitle" style="margin-bottom: -30px;">Invalid filter parameters!</div>';

        $GUI .= self::showSearchGUI($matches);
        $GUI .= self::showTagPageNavigationGUI($page, $tag, $sort);

        return $GUI;
	}

	private static function showTagSortGUI($tag, $sort, $page)
	{
		$sortClass1 = 'sortBoxItem' . ($sort == self::$SORT_TYPE_2?' sortBoxItemSelected':' sortBoxItemNotSelected');
		$sortClass2 = 'sortBoxItem' . ($sort == self::$SORT_TYPE_3?' sortBoxItemSelected':' sortBoxItemNotSelected');

		$sortClick1 = $sort != self::$SORT_TYPE_2?'location.href=\'tag.php?tag='.$tag.'&sort='.self::$SORT_TYPE_2.'&page='.$page.'\'':'';
		$sortClick2 = $sort != self::$SORT_TYPE_3?'location.href=\'tag.php?tag='.$tag.'&sort='.self::$SORT_TYPE_3.'&page='.$page.'\'':'';

		$GUI = '<div class="sortBoxContainer">
					<div class="sortBox" style="width: 240px;">
						<div class="'.$sortClass1.'" onclick="'.$sortClick1.'">Most Recent</div>
						<div class="'.$sortClass2.'" onclick="'.$sortClick2.'">Oldest</div>
					</div>
				</div>
				<div class="sortBoxSeparator"></div>';

		return $GUI;
	}

	private static function showTagPageNavigationGUI($page, $tag, $sort)
	{
		$prevItem = ($page > 1?'<a href="tag.php?tag=' . $tag . '&sort=' . $sort . '&page=' . (intval($page) - 1) . '">':'') . '< Prev' . ($page > 1?'</a>':''); 
		$nextItem = ($page < self::$lastPage?'<a href="tag.php?tag=' . $tag . '&sort=' . $sort . '&page=' . (intval($page) + 1) . '">':'') . 'Next >' . ($page < self::$lastPage?'</a>':'');
		$pageItem = 'Page ' . $page;

		$GUI = '<div class="pageNavigationContainer"><div class="pageNavigation noSelection">' .
		 '<div class="pageNavigationItem' . ($page > 1?' pointCursor':' defaultCursor') . '">' . $prevItem . '</div>' .
		 '<div class="pageNavigationItem defaultCursor" style="color: #383838;">' . $pageItem . '</div>' .
		 '<div class="pageNavigationItem' . ($page < self::$lastPage?' pointCursor':' defaultCursor') . '">' . $nextItem . '</div>' .
		 '</div></div>';

		return $GUI;
	}

	public static function postComment($captcha, $name, $email, $comment, $date, $id)
	{
		if(!$captcha)
            return '<script type="text/javascript">displayError(2);</script>';
        
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LfzshATAAAAACEIkKtfsZFNlwFM387rrmqA954c&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
        $responseData = json_decode($response);

        if (!$responseData->success)
            return '<script type="text/javascript">displayError(3);</script>';
        
        $name = strip_tags(trim($name));
        $email = trim($email);
        $comment = strip_tags(trim($comment));

        if ($name == "" || $email == "" || $comment == "")
            return '<script type="text/javascript">displayError(0);</script>';
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return '<script type="text/javascript">displayError(1);</script>';
        
        if (preg_replace('/(\v+|\r\n+| +|\[bold\]+|\[\/bold\]+|\[italic\]+|\[\/italic\]+)/','', $comment) == "")
            return '<script type="text/javascript">displayError(4);</script>';
        
        //Connect to Database
        $db = Ramtin::connect();
                        
        //Insert into 'comments'
        $ins = $db->prepare("INSERT INTO comments(id,name,email,date,comment,post_id) VALUES(:field1,:field2,:field3,:field4,:field5,:field6)");
        $ins->execute(array(':field1' => '', ':field2' => $name, ':field3' => $email, ':field4' => $date, ':field5' => $comment, ':field6' => $id));
    }

    public static function readComments()
    {
    	$wholeComments = "";
    	//Connect to Database
        $db = Ramtin::connect();

        //Read each row from posts table
        foreach($db->query('SELECT * FROM comments ORDER BY date ASC') as $row)
        {
            $qname = $row['name'];
            $qcomment = $row['comment'];
            $timezone = new DateTimeZone('America/Los_Angeles');
            $odate = DateTime::createFromFormat('Y-m-d H:i:s', $row['date'], $timezone);
            $qdate = $odate->format('F jS, Y (h:i A)');
            $qpost_id = $row['post_id'];

            if($qpost_id != $_GET['id'])
                continue;

            //Encode & escape special characters in comment read from Database
            $qcomment = preg_replace('/\v+|\\\[rn]/','<br/>', $qcomment);
            $qcomment = json_encode(utf8_encode($qcomment));
            $qcomment = str_replace("'", "\'", $qcomment);

            $wholeComments .= "<script type='text/javascript'>displayComment('$qname', '$qdate', '$qcomment');</script>";
        }
        
        return $wholeComments;
    }

    public static function readPostByID($id)
    {
    	return self::readPost('SELECT * FROM posts WHERE id = '. $id, false, true);
    }

    public static function readPeakPostByPage($page_id)
    {
    	return self::readPost('SELECT * FROM posts WHERE page_id LIKE "%' . $page_id . '%" ORDER BY date DESC', true, false);
    }

    private static function readPost($sqlCommand, $peakPost, $onlyFirstMatch)
    {
    	//Connect to Database
        $db = Ramtin::connect();

        $GUI = "";

        //Read each row from posts table
		foreach($db->query($sqlCommand) as $row)
		{
			$title = $row['title'];
			$content = $peakPost?$row['peak_content']:$row['content'];
			$timezone = new DateTimeZone('America/Los_Angeles');
            $ufDate = DateTime::createFromFormat('Y-m-d H:i:s', $row['date'], $timezone);
            $date = $ufDate->format('F jS, Y');
			$author = $row['author'];
			$id = $row['id'];
			$tagsStr = $row['tags'];
			$tags = json_encode(explode(',' , $tagsStr));

			//Encode & escape special characters in HTML content read from Database
			$content = json_encode(utf8_encode($content));
			$content = str_replace("'", "\'", $content);

			//Pass to Javascript function to display data in form of post
			$GUI .= "<script type='text/javascript'>displayPost('$title', '$date', '$author', '$content', '$tags', '$peakPost', '$id');</script>";

			if($onlyFirstMatch) break;
		}

		return $GUI;
    }
}

?>