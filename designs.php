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
        <?php require('resources/framework.php'); ?>
    </head>
    <body>
        <div class="overallShadow noSelection"></div>
        <div id="wrapper">
            <!--Followup Tabs-->
            <div class="headerFollowupTabs" id="headerFollowup">
                <center>
                    <div class="headerTabs">
                        <div class="tab" onclick="location.href='index.php'">Home</div>
                        <div class="tab">Blog</div>
                        <div class="tab">Projects</div>
                        <div class="tabSelected">Designs</div>
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
                        <div class="tab">Blog</div>
                        <div class="tab">Projects</div>
                        <div class="tabSelected">Designs</div>
                        <div class="tab">About</div>
                        <div class="tab">Contact</div>
                    </div>
                </center>
                <div class="headerSeparator"></div>
            </div>
            <div id="content">
                <div class="postsBody" id="postsBody">
                    <div class="designGallery">
                        <div class="designThumbnailWrapper">
                            <div class="designThumbnailLoading"></div>
                            <div class="designThumbnail">
                                <img src="http://www.zemwallpapers.com/wp-content/uploads/2015/08/Free-Stock-Image-61.jpg" data-state="loading" onload="createThumbnail(this);" onclick="showDesign(this);" />
                            </div>
                        </div>
                        <div class="designThumbnailWrapper">
                            <div class="designThumbnailLoading"></div>
                            <div class="designThumbnail">
                                <img src="https://i.ytimg.com/vi/YIL3iyBJHr0/maxresdefault.jpg" data-state="loading" onload="createThumbnail(this);" onclick="showDesign(this);" />
                            </div>
                        </div>
                        <div class="designThumbnailWrapper">
                            <div class="designThumbnailLoading"></div>
                            <div class="designThumbnail">
                                <img src="http://www.binarries.com/wp-content/uploads/2013/10/stock3.jpg" data-state="loading" onload="createThumbnail(this);" onclick="showDesign(this);" />
                            </div>
                        </div>
                        <div class="designThumbnailWrapper">
                            <div class="designThumbnailLoading"></div>
                            <div class="designThumbnail">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/1/1b/1967_tube_stock_farewell_at_Stockwell_by_Trowbridge_Estate.png" data-state="loading" onload="createThumbnail(this);" onclick="showDesign(this);" />
                            </div>
                        </div>
                        <div class="designThumbnailWrapper">
                            <div class="designThumbnailLoading"></div>
                            <div class="designThumbnail">
                                <img src="https://i.ytimg.com/vi/Y59tS-kfVlM/maxresdefault.jpg" data-state="loading" onload="createThumbnail(this);" onclick="showDesign(this);" />
                            </div>
                        </div>
                        <div class="designThumbnailWrapper">
                            <div class="designThumbnailLoading"></div>
                            <div class="designThumbnail">
                                <img src="http://a.fastcompany.net/multisite_files/fastcompany/poster/2014/12/3040071-poster-p-1-should-i-cash-in-my-employee-stock-options.jpg" data-state="loading" onload="createThumbnail(this);" onclick="showDesign(this);" />
                            </div>
                        </div>
                        <div class="designThumbnailWrapper">
                            <div class="designThumbnailLoading"></div>
                            <div class="designThumbnail">
                                <img src="http://www.somebodymarketing.com/wp-content/uploads/2013/05/Stock-Dock-House.jpg" data-state="loading" onload="createThumbnail(this);" onclick="showDesign(this);" />
                            </div>
                        </div>
                        <div class="designThumbnailWrapper">
                            <div class="designThumbnailLoading"></div>
                            <div class="designThumbnail">
                                <img src="http://s3.footagesearch.com/stills/JW01_081.jpg" data-state="loading" onload="createThumbnail(this);" onclick="showDesign(this);" />
                            </div>
                        </div>
                        <div class="designThumbnailWrapper">
                            <div class="designThumbnailLoading"></div>
                            <div class="designThumbnail">
                                <img src="http://imagesci.com/img/2013/08/lock-stock-and-two-smoking-barrels-20523-hd-wallpapers.jpg" data-state="loading" onload="createThumbnail(this);" onclick="showDesign(this);" />
                            </div>
                        </div>
                        <div class="designThumbnailWrapper">
                            <div class="designThumbnailLoading"></div>
                            <div class="designThumbnail">
                                <img src="http://design.websiteable.info/wp-content/uploads/2015/07/Nature-Beach-Stock-Photography-Nature.jpg" data-state="loading" onload="createThumbnail(this);" onclick="showDesign(this);" />
                            </div>
                        </div>
                        <div class="designThumbnailWrapper">
                            <div class="designThumbnailLoading"></div>
                            <div class="designThumbnail">
                                <img src="https://cravedfw.files.wordpress.com/2015/04/dsc07087.jpg" data-state="loading" onload="createThumbnail(this);" onclick="showDesign(this);" />
                            </div>
                        </div>
                        <div class="designThumbnailWrapper">
                            <div class="designThumbnailLoading"></div>
                            <div class="designThumbnail">
                                <img src="http://img00.deviantart.net/720c/i/2013/171/0/d/portrait_4_by_liam_stock-d69wpf7.jpg" data-state="loading" onload="createThumbnail(this);" onclick="showDesign(this);" />
                            </div>
                        </div>
                    </div>
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
        <div class="photoWindow">
            <div class="photoWindowView">
                <div class="photoWindowImage" onmouseover="switchImageControls(true);" onmouseout="switchImageControls(false);">
                    <div class="photoWindowImageControls">
                        <div class="photoWindowImageControlsNavigationButton photoWindowImageControlPrev pointCursor"></div>
                        <div class="photoWindowImageControlsFullscreenWrapper">
                            <div class="photoWindowImageControlFullscreenButton pointCursor"></div>
                        </div>
                        <div class="photoWindowImageControlsNavigationButton photoWindowImageControlNext pointCursor"></div>
                    </div>
                </div>
            </div>
            <div class="photoWindowDetails">
                <div class="photoWindowCloseButtonWrapper pointCursor">
                    <div class="photoWindowCloseButton">
                        <div class="photoWindowCloseButtonHover" onclick="hideDesign();"></div>
                    </div>
                </div>
                <div class="photoWindowTitle">Title here</div>
                <div class="photoWindowTitleSeparator"></div>
                <div class="photoWindowDescriptionWrapper">
                    <div class="postInfo">Category: Graphical User Interface</div>
                    <div class="photoWindowDescription defaultText">
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                        Right now I just want to test if part of the text will be hidden under the vertical scrollbar.
                    </div>
                    <div class="tagsWrapper">
                        <div class="tag">Tag1</div>
                        <div class="tag">Tag2</div>
                        <div class="tag">Tag3</div>
                        <div class="tag">Tag4</div>
                    </div>
                </div>
                <div class="photoWindowTitleSeparator"></div>
                <div class="photoWindowToolbox">
                    <div class="photoWindowToolboxItem photoWindowToolboxItemLink pointCursor" title="Copy Link">
                        <div class="photoWindowToolboxItem photoWindowToolboxItemLinkHover"></div>
                    </div>
                    <div class="photoWindowToolboxItem photoWindowToolboxItemDownload pointCursor" title="Download Image">
                        <div class="photoWindowToolboxItem photoWindowToolboxItemDownloadHover"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
