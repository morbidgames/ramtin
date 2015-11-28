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
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <?php require('resources/framework.php'); ?>
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
                    <!--post-->
                    <?php echo Ramtin::readPostByID($_GET['id']); ?>
                    <!--/post-->

                    <!--Comments-->
                    <div class="commentSection" id="commentBox">
                        <div style="width: 100%;">
                            <div class="commentTitle">COMMENTS</div>
                            <div class="postHeaderSeparator"></div>
                        </div>
                    </div>
                    <div class="commentSection">
                        <!--Lables-->
                        <div style="float: left; width: 105px; padding-left: 5px;">
                            <div class="commentLabel">Name</div>
                            <div class="commentLabel">Email</div>
                            <div class="commentLabel">Comment</div>
                        </div>
                        <!--Form-->
                        <div style="float: left; width: 445px;">
                            <form method="post">
                                <div class="commentFormRow">
                                    <input class="formText" type="text" name="name" maxlength="50">
                                </div>
                                <div class="commentFormRow">
                                    <input class="formText" type="text" placeholder="example@email.com" name="email" maxlength="50">
                                </div>
                                <div class="commentFormRow">
                                    <div class="commentFormattingBox formatBold" onmousedown="insertFormatTag('bold', 'comments');" title="Alt+A">
                                        <div class="formatInnerHover formatBoldHover"></div>
                                    </div>
                                    <div class="commentFormattingBox formatItalic" onmousedown="insertFormatTag('italic', 'comments');" title="Alt+I">
                                        <div class="formatInnerHover formatItalicHover"></div>
                                    </div>
                                    <div class="commentFormattingBox formatEmo" onclick="switchEmoBox();">
                                        <div class="formatInnerHover formatEmoHover"></div>
                                    </div>
                                </div>
                                    <div class="emoBox" id="emoBox">
                                        <div class="emoBoxItem" title="[ambivalent] or :|" onclick="insertEmo('ambivalent', 'comments')"><img src="images/emoticons/ambivalent.png"/></div>
                                        <div class="emoBoxItem" title="[angry] or X(" onclick="insertEmo('angry', 'comments')"><img src="images/emoticons/angry.png"/></div>
                                        <div class="emoBoxItem" title="[confused] or :S" onclick="insertEmo('confused', 'comments')"><img src="images/emoticons/confused.png"/></div>
                                        <div class="emoBoxItem" title="[content] or /:)" onclick="insertEmo('content', 'comments')"><img src="images/emoticons/content.png"/></div>
                                        <div class="emoBoxItem" title="[cool] or B)" onclick="insertEmo('cool', 'comments')"><img src="images/emoticons/cool.png"/></div>
                                        <div class="emoBoxItem" title="[crazy] or ;P" onclick="insertEmo('crazy', 'comments')"><img src="images/emoticons/crazy.png"/></div>
                                        <div class="emoBoxItem" title="[cry] or :'(" onclick="insertEmo('cry', 'comments')"><img src="images/emoticons/cry.png"/></div>
                                        <div class="emoBoxItem" title="[embarrassed] or (:(" onclick="insertEmo('embarrassed', 'comments')"><img src="images/emoticons/embarrassed.png"/></div>
                                        <div class="emoBoxItem" title="[footinmouth] or <:(" onclick="insertEmo('footinmouth', 'comments')"><img src="images/emoticons/footinmouth.png"/></div>
                                        <div class="emoBoxItem" title="[frown] or :(" onclick="insertEmo('frown', 'comments')"><img src="images/emoticons/frown.png"/></div>
                                        <div class="emoBoxItem" title="[gasp] or :O" onclick="insertEmo('gasp', 'comments')"><img src="images/emoticons/gasp.png"/></div>
                                        <div class="emoBoxItem" title="[grin] or :D" onclick="insertEmo('grin', 'comments')"><img src="images/emoticons/grin.png"/></div>
                                        <div class="emoBoxItem" title="[heart] or <3" onclick="insertEmo('heart', 'comments')"><img src="images/emoticons/heart.png"/></div>
                                        <div class="emoBoxItem" title="[hearteyes] or &)" onclick="insertEmo('hearteyes', 'comments')"><img src="images/emoticons/hearteyes.png"/></div>
                                        <div class="emoBoxItem" title="[innocent] or O:)" onclick="insertEmo('innocent', 'comments')"><img src="images/emoticons/innocent.png"/></div>
                                        <div class="emoBoxItem" title="[kiss] or :*" onclick="insertEmo('kiss', 'comments')"><img src="images/emoticons/kiss.png"/></div>
                                        <div class="emoBoxItem" title="[laughing] or :))" onclick="insertEmo('laughing', 'comments')"><img src="images/emoticons/laughing.png"/></div>
                                        <div class="emoBoxItem" title="[minifrown] or :<" onclick="insertEmo('minifrown', 'comments')"><img src="images/emoticons/minifrown.png"/></div>
                                        <div class="emoBoxItem" title="[minismile] or :>" onclick="insertEmo('minismile', 'comments')"><img src="images/emoticons/minismile.png"/></div>
                                        <div class="emoBoxItem" title="[moneymouth] or :$" onclick="insertEmo('moneymouth', 'comments')"><img src="images/emoticons/moneymouth.png"/></div>
                                        <div class="emoBoxItem" title="[naughty] or 3:)" onclick="insertEmo('naughty', 'comments')"><img src="images/emoticons/naughty.png"/></div>
                                        <div class="emoBoxItem" title="[nerd] or 8)" onclick="insertEmo('nerd', 'comments')"><img src="images/emoticons/nerd.png"/></div>
                                        <div class="emoBoxItem" title="[notamused] or ':/" onclick="insertEmo('notamused', 'comments')"><img src="images/emoticons/notamused.png"/></div>
                                        <div class="emoBoxItem" title="[sarcastic] or ;D" onclick="insertEmo('sarcastic', 'comments')"><img src="images/emoticons/sarcastic.png"/></div>
                                        <div class="emoBoxItem" title="[sealed] or :X" onclick="insertEmo('sealed', 'comments')"><img src="images/emoticons/sealed.png"/></div>
                                        <div class="emoBoxItem" title="[sick] or :&" onclick="insertEmo('sick', 'comments')"><img src="images/emoticons/sick.png"/></div>
                                        <div class="emoBoxItem" title="[slant] or :/" onclick="insertEmo('slant', 'comments')"><img src="images/emoticons/slant.png"/></div>
                                        <div class="emoBoxItem" title="[smile] or :)" onclick="insertEmo('smile', 'comments')"><img src="images/emoticons/smile.png"/></div>
                                        <div class="emoBoxItem" title="[thumbsdown] or (n)" onclick="insertEmo('thumbsdown', 'comments')"><img src="images/emoticons/thumbsdown.png"/></div>
                                        <div class="emoBoxItem" title="[thumbsup] or (y)" onclick="insertEmo('thumbsup', 'comments')"><img src="images/emoticons/thumbsup.png"/></div>
                                        <div class="emoBoxItem" title="[wink] or ;)" onclick="insertEmo('wink', 'comments')"><img src="images/emoticons/wink.png"/></div>
                                        <div class="emoBoxItem" title="[yuck] or :P" onclick="insertEmo('yuck', 'comments')"><img src="images/emoticons/yuck.png"/></div>
                                        <div class="emoBoxItem" title="[yum] or :b" onclick="insertEmo('yum', 'comments')"><img src="images/emoticons/yum.png"/></div>
                                    </div>
                                <div class="commentFormRow">
                                    <textarea id="comments" name="comment" maxlength="200" onChange="showLettersLeft('comments', 'lettersCount');" onKeyUp="showLettersLeft('comments', 'lettersCount');" onKeyDown="showLettersLeft('comments', 'lettersCount'); formatShortcut(event, this.id);"></textarea>
                                    <!--Captcha/Submit/Letters Left-->
                                    <div style="width: 305px; float: left; padding-top: 8px;">
                                        <div class="g-recaptcha" data-sitekey="6LfzshATAAAAAPyQ8eprXUJGSuKu2aDIeg4fRMdY"></div>
                                    </div>
                                    <div style="width: 140px; float: left;">
                                        <div style="width: 100%; height: 36px; font-size: 14px; color: #373737; font-family: Titillium Web; text-align: right;" id="lettersCount">
                                            200 letters left
                                        </div>
                                        <div style="width: 100%; height: 45px; margin-left: 20px;">
                                            <input id="submitButton" type="submit" name="add" value="SUBMIT">
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
                                    <li type="circle">Not leaving rude comments!</li>
                                    <li type="circle">Not ridiculing other commenters!</li>
                                    <li type="circle">Not using comments to advertise your products, websites, or services.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!--/Comments-->
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
        <?php
            if(isset($_POST['add']))
            {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $comment = $_POST['comment'];
                $timezone = new DateTime('', new DateTimeZone('America/Los_Angeles'));
                $date = $timezone->format('Y-m-d H:i:s');
                $captcha = $_POST['g-recaptcha-response'];
                
                echo Ramtin::postComment($captcha, $name, $email, $comment, $date, $_GET['id']);
            }
        ?>
        <?php echo Ramtin::readComments(); ?>
    </body>
</html>
