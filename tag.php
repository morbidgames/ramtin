<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ramtin</title>
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
                        <div class="tab" onclick="location.href='index.php'">Home</div>
                        <div class="tab">Codes</div>
                        <div class="tab">Projects</div>
                        <div class="tab">Designs</div>
                        <div class="tab">About</div>
                        <div class="tab">Contact</div>
                    </div>
                </center>
                <div class="headerSeparator"></div>
            </div>
            <!--/Followup Tabs-->
            <div class="headerContainer">
                <div class="header">
                    <div class="searchBox">
                        <div class="searchTextWrapper">
                            <input id="searchText" class="searchText" type="text" placeholder="Search..." name="search" onkeypress="keyNavigateToSearch(event, 'searchText');" />
                        </div>
                        <div class="searchButton">
                            <div class="searchButtonHover" onclick="navigateToSearch('searchText');"></div>
                        </div>
                    </div>
                </div>
                <center>
                    <div class="headerTabs">
                        <div class="tab" onclick="location.href='index.php'">Home</div>
                        <div class="tab">Codes</div>
                        <div class="tab">Projects</div>
                        <div class="tab">Designs</div>
                        <div class="tab">About</div>
                        <div class="tab">Contact</div>
                    </div>
                </center>
                <div class="headerSeparator"></div>
            </div>
            <div id="content">
                <div class="postsBody" id="postsBody">
                    <div class="filterTitle">
                        Filtering by tag: <?php echo $_GET['tag']; ?>
                    </div>
                    <!--post-->
                    <?php
                        //Connect to Database
                        $db = new PDO('mysql:host=localhost;dbname=ramtin_data;charset=utf8', 'root', '');

                        $tagname = "%" . $_GET['tag'] . "%";

                        //Read each row from posts table
                        foreach($db->query("SELECT * FROM posts WHERE tags LIKE '$tagname'") as $row)
                        {
                            $qtitle = $row['title'];
                            $qcontent = $row['peak_content'];
                            $qdate = $row['date'];
                            $qauthor = $row['author'];
                            $qid = $row['id'];
                            $qalltags = $row['tags'];
                            $tags = json_encode(explode(",", $qalltags));

                            //Encode & escape special characters in HTML content read from Database
                            $qcontent = json_encode(utf8_encode($qcontent));
                            $qcontent = str_replace("'", "\'", $qcontent);

                            //Pass to Javascript function to display data in form of post
                            echo "<script type='text/javascript'>displayPost('$qtitle', '$qdate', '$qauthor', '$qcontent', '$tags', true, '$qid');</script>";
                        }
                    ?>
                    <!--/post-->
                </div>
            </div>
            <div class="footer">
            	<div class="footerLeft">
                    <div class="footerLeftIcon footerLeftIconFacebook">
                        <a href="https://facebook.com/ramtin.soltani" target="_blank">
                            <div class="footerLeftIconInner footerLeftIconFacebookHover"></div>
                        </a>
                    </div>
                    <div class="footerLeftIcon footerLeftIconTwitter">
                        <a href="https://twitter.com/morbid_games" target="_blank">
                            <div class="footerLeftIconInner footerLeftIconTwitterHover"></div>
                        </a>
                    </div>
                    <div class="footerLeftIcon footerLeftIconLinkedin">
                        <a href="http://www.linkedin.com/in/ramtinsoltani" target="_blank">
                            <div class="footerLeftIconInner footerLeftIconLinkedinHover"></div>
                        </a>
                    </div>
                    <div class="footerLeftIcon footerLeftIconGithub">
                        <a href="https://github.com/morbidgames" target="_blank">
                            <div class="footerLeftIconInner footerLeftIconGithubHover"></div>
                        </a>
                    </div>
                    <div class="footerLeftIcon footerLeftIconScirra">
                        <a href="https://www.scirra.com/users/ramtinsoltani" target="_blank">
                            <div class="footerLeftIconInner footerLeftIconScirraHover"></div>
                        </a>
                    </div>
                    <div class="footerLeftIcon footerLeftIconNewgrounds">
                        <a href="http://morbidgames.newgrounds.com/" target="_blank">
                            <div class="footerLeftIconInner footerLeftIconNewgroundsHover"></div>
                        </a>
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
