<!doctype html>
<html>
<head>
<meta charset="utf-8">
<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript" src="../resources/scripts.js"></script>
<link href="../resources/styles.css" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
<title>Comment Sample</title>
</head>

<body>
	<div style="width: 794px; padding-top: 20px;" id="commentBox">
    	<div style="width: 100%;">
            <div class="commentTitle">COMMENTS</div>
            <div class="postHeaderSeparator"></div>
        </div>
        <!-- Comment Display Code
            <div class="commentHeader">
                <div class="commenterName"><font color="ee3434">Name</font> said:</div>
                <div class="commentDate">Date & Time</div>
            </div>
            <div style="width: 100%;">
                <div class="commentContent">Comment</div>
            </div>
            <div class="commentSeparator"></div>
        -->
    </div>
	<div style="width: 794px; padding-top: 20px;">
    	<!--Lables-->
        <div style="float: left; width: 105px; padding-left: 5px;">
        	<div class="commentLabel">Name</div>
            <div class="commentLabel">Email</div>
            <div class="commentLabel">Comment</div>
        </div>
        <!--Form-->
        <div style="float: left; width: 445px;">
        	<form action="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" method="post">
                <div style="width: 100%; height: 30px; padding-bottom: 10px;">
                	<input type="text" name="name">
                </div>
                <div style="width: 100%; height: 30px; padding-bottom: 10px;">
                	<input type="text" placeholder="Example: john@email.com" name="email">
                </div>
                <div style="width: 100%; height: 30px; padding-bottom: 10px;">
                	<textarea id="comments" name="comment" maxlength="200" onChange="showLettersLeft('comments', 'lettersCount');" onKeyUp="showLettersLeft('comments', 'lettersCount');" onKeyDown="showLettersLeft('comments', 'lettersCount');"></textarea>
                    <!--Captcha/Submit/Letters Left-->
                    <div style="width: 315px; float: left; padding-top: 8px;">
                    	<div class="g-recaptcha" data-sitekey="6Lf2Ag0TAAAAAJiW7vTfS_xlz4fBi5wa7HE6LTvj"></div>
                    </div>
                    <div style="width: 130px; float: left;">
                    	<div style="width: 100%; height: 36px; font-size: 14px; color: #373737; font-family: Titillium Web; text-align: right;" id="lettersCount">
                        	200 letters left
                        </div>
                        <div style="width: 100%; height: 45px;">
                        	<input id="submitButton" type="submit" name="add" value="SUBMIT" onMouseOver="submitButtonOver('submitButton');" onMouseOut="submitButtonOut('submitButton');">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!--Notifications-->
        <div style="float: right; width: 208px; word-wrap: break-word; margin-left: 30px;">
        	<div class="notificationHeader" id="errorTitle" style="visibility: hidden;"></div>
            <div class="notificationContent" id="errorContent" style="visibility: hidden;"></div>
        	<div class="notificationHeader">By clicking submit you agree to:</div>
            <div class="notificationContent">
            	<ol>
                	<li type="circle">Not leave rude comments!</li>
                    <li type="circle">Not ridicule other commenters!</li>
                    <li type="circle">Not use comments to advertise your products, websites, or services.</li>
                </ol>
            </div>
        </div>
    </div>
</body>
<?php
	if(isset($_POST['add']))
    {
    	$name = $_POST['name'];
        $email = $_POST['email'];
        $comment = $_POST['comment'];
		$timezone = new DateTime('', new DateTimeZone('America/Los_Angeles'));
		$date = $timezone->format('F jS, Y (h:i A)');
		$captcha = $_POST['g-recaptcha-response'];
		$currentURL = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		
		if(!$captcha)
		{
			echo '<script type="text/javascript">displayError(2);</script>';
		}
		else
		{
			$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Lf2Ag0TAAAAABwH9he1oeyAZ1-Dp_8VmlIwJYB8&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
			if ($response.success == false)
			{
				echo '<script type="text/javascript">displayError(3);</script>';
			}
			else
			{
				$name = trim($name);
				$email = trim($email);
				$comment = trim($comment);
				
				if ($name == "" || $email == "" || $comment == "")
				{
					echo '<script type="text/javascript">displayError(0);</script>';
				}
				elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					echo '<script type="text/javascript">displayError(1);</script>';
				}
				else
				{
					mysql_connect("ramtin.ipagemysql.com", "ramtin", "Immol@tion13");
					mysql_select_db("c0mments");
					mysql_query("INSERT INTO comments (id, url, name, email, comment, date) VALUES ('', '$currentURL', '$name', '$email', '$comment', '$date')");
				}
			}
		}
    }
?>
<?php
	mysql_connect('ramtin.ipagemysql.com', 'ramtin', 'Immol@tion13');
	mysql_select_db('c0mments');
	$run = mysql_query('SELECT * FROM comments ORDER BY id DESC');
	$rows = mysql_num_rows($run);
	if ($rows > 0)
	{
		while ($row = mysql_fetch_assoc($run))
		{
			$dbname = $row['name'];
			$dbcomment = $row['comment'];
			$dbdate = $row['date'];
			$dbcommentURL = $row['url'];
			
			if ($dbcommentURL == "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]")
			{
				$dbcomment = preg_replace('/\v+|\\\[rn]/','<br/>', $dbcomment);
				echo "<script type='text/javascript'>displayComment('$dbname', '$dbdate', '$dbcomment');</script>";
			}
		}
	}
?>
</html>
