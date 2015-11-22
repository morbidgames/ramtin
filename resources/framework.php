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
	private static $SORT_TYPE_1 = "best"; 		//For best matches
	private static $SORT_TYPE_2 = "recent"; 	//For most recent (DESC)
	private static $SORT_TYPE_3 = "old"; 		//For oldest (ASC)
	private static $RESULTS_PER_PAGE = 20;		//For showing results in each page (search.php)

	private static function validateParam($param)
	{
		if(!isset($param)) return false;
		if($param == "") return false;

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
		if(!self::validateParam($key) || !self::validateParam($sortType) || !self::validateParam($pageNum)) return false;

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
        	array_push($matches, $match);
        	if($sortType == self::$SORT_TYPE_1) $matches[count($matches) - 1]->setMatchPoint($keys);
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

        return $matches;
	}

	public static function showSearchGUI($match)
	{

	}
}

?>