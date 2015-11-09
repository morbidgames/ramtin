<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Ramtin's Online Resume</title>
        <link href="resources/styles.css" rel="stylesheet" type="text/css">
		<link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
        <link rel="apple-touch-icon" sizes="57x57" href="/images/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/images/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/images/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/images/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/images/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/images/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/images/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/images/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon-180x180.png">
        <link rel="icon" type="image/png" href="/images/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/images/android-chrome-192x192.png" sizes="192x192">
        <link rel="icon" type="image/png" href="/images/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="/images/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="/images/manifest.json">
        <link rel="mask-icon" href="/images/safari-pinned-tab.svg" color="#ea3433">
        <link rel="shortcut icon" href="/images/favicon.ico">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-TileImage" content="/images/mstile-144x144.png">
        <meta name="msapplication-config" content="/images/browserconfig.xml">
        <meta name="theme-color" content="#ea3433">
        <script type="text/javascript" src="resources/scripts.js"></script>
    </head>
    <body>
        <div id="wrapper">
            <!--Followup Tabs-->
            <div class="headerFollowupTabs" id="headerFollowup">
                <center>
                    <div class="headerTabs">
                        <div class="tabSelected" id="ftab1">Home</div>
                        <div class="tab" id="ftab2" onMouseOver="selectTab('ftab2', false);" onMouseOut="selectTab('ftab2', true);">Resume</div>
                        <div class="tab" id="ftab3" onMouseOver="selectTab('ftab3', false);" onMouseOut="selectTab('ftab3', true);">Projects</div>
                        <div class="tab" id="ftab4" onMouseOver="selectTab('ftab4', false);" onMouseOut="selectTab('ftab4', true);">Designs</div>
                        <div class="tab" id="ftab5" onMouseOver="selectTab('ftab5', false);" onMouseOut="selectTab('ftab5', true);">About</div>
                        <div class="tab" id="ftab6" onMouseOver="selectTab('ftab6', false);" onMouseOut="selectTab('ftab6', true);">Contact</div>
                    </div>
                </center>
                <div class="headerSeparator"></div>
            </div>
            <!--/Followup Tabs-->
            <div class="headerContainer">
                <center>
                    <div class="headerTabs">
                        <div class="tabSelected" id="tab1">Home</div>
                        <div class="tab" id="tab2" onMouseOver="selectTab('tab2', false);" onMouseOut="selectTab('tab2', true);">Resume</div>
                        <div class="tab" id="tab3" onMouseOver="selectTab('tab3', false);" onMouseOut="selectTab('tab3', true);">Projects</div>
                        <div class="tab" id="tab4" onMouseOver="selectTab('tab4', false);" onMouseOut="selectTab('tab4', true);">Designs</div>
                        <div class="tab" id="tab5" onMouseOver="selectTab('tab5', false);" onMouseOut="selectTab('tab5', true);">About</div>
                        <div class="tab" id="tab6" onMouseOver="selectTab('tab6', false);" onMouseOut="selectTab('tab6', true);">Contact</div>
                    </div>
                </center>
                <div class="headerSeparator"></div>
            </div>
            <div id="content">
                <div class="postsBody" id="postsBody">
                    <!--post-->
                    <?php
                        //Connect to Database
                        $db = new PDO('mysql:host=localhost;dbname=ramtin_data;charset=utf8', 'root', '');

                        //Read each row from posts table
                        foreach($db->query('SELECT * FROM posts') as $row)
                        {
                            $qtitle = $row['title'];
                            $qcontent = $row['content'];
                            $qpage = $row['page_id'];
                            if($qpage == 'home')
                            {
                                //Encode & escape special characters in HTML content read from Database
                                $qcontent = json_encode(utf8_encode($qcontent));
                                $qcontent = str_replace("'", "\'", $qcontent);

                                //Pass to Javascript function to display data in form of post
                                echo "<script type='text/javascript'>displayPost('$qtitle', '$qcontent');</script>";
                            }
                        }
                    ?>
                    <!--/post-->
                </div>
            </div>
            <div class="footer">
            	<div class="footerLeft">
                	<div class="footerLeftIcon">
                    	<a href="https://facebook.com/ramtin.soltani" target="_blank"><img src="images/social_facebook.jpg" border="0" width="50" height="50" id="icon1" title="Facebook" onMouseOver="iconSelection('icon1', true);" onMouseOut="iconSelection('icon1', false);"/></a>
                    </div>
                    <div class="footerLeftIcon">
                    	<a href="https://twitter.com/morbid_games" target="_blank"><img src="images/social_twitter.jpg" border="0" width="50" height="50" id="icon2" title="Twitter" onMouseOver="iconSelection('icon2', true);" onMouseOut="iconSelection('icon2', false);"/></a>
                    </div>
                    <div class="footerLeftIcon">
                    	<a href="http://www.linkedin.com/in/ramtinsoltani" target="_blank"><img src="images/social_linkedin.jpg" border="0" width="50" height="50" id="icon3" title="LinkedIn" onMouseOver="iconSelection('icon3', true);" onMouseOut="iconSelection('icon3', false);"/></a>
                    </div>
                    <div class="footerLeftIcon">
                    	<a href="https://github.com/morbidgames" target="_blank"><img src="images/social_github.jpg" border="0" width="50" height="50" id="icon4" title="Github" onMouseOver="iconSelection('icon4', true);" onMouseOut="iconSelection('icon4', false);"/></a>
                    </div>
                    <div class="footerLeftIcon">
                    	<a href="https://www.scirra.com/users/ramtinsoltani" target="_blank"><img src="images/social_scirra.jpg" border="0" width="50" height="50" id="icon5" title="Scirra" onMouseOver="iconSelection('icon5', true);" onMouseOut="iconSelection('icon5', false);"/></a>
                    </div>
                    <div class="footerLeftIcon">
                    	<a href="http://morbidgames.newgrounds.com/" target="_blank"><img src="images/social_newgrounds.jpg" border="0" width="50" height="50" id="icon6" title="Newgrounds" onMouseOver="iconSelection('icon6', true);" onMouseOut="iconSelection('icon6', false);"/></a>
                    </div>
                </div>
                <div class="footerCenter">
                	Copyright 2015<br/>All rights are reserved by Ramtin Soltani.<br/>Any reproduction, dupliction and/or distribution without permission is prohibited by the federal law.
                </div>
                <div class="footerRight"></div>
            </div>
        </div>
    </body>
</html>
