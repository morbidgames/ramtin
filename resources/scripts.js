// JavaScript Document

window.onscroll = function() {scrollTabsPlacement()};
document.onmousewheel = function() {scrollTabsPlacement()};

function selectTab(tabID, deselect)
{
	if (deselect)
		document.getElementById(tabID).style.color = "#373737";
	else
		document.getElementById(tabID).style.color = "#ee3434";
}

function scrollTabsPlacement()
{
	if (window.pageYOffset > 187)
		document.getElementById("headerFollowup").style.visibility = "visible";
	else
		document.getElementById("headerFollowup").style.visibility = "hidden";
}

function iconSelection(iconID, makeSelection)
{
	var iconPath = "images/social_";
	
	switch(iconID)
	{
		case 'icon1':
			iconPath = iconPath + "facebook";
			break;
		case 'icon2':
			iconPath = iconPath + "twitter";
			break;
		case 'icon3':
			iconPath = iconPath + "linkedin";
			break;
		case 'icon4':
			iconPath = iconPath + "github";
			break;
		case 'icon5':
			iconPath = iconPath + "scirra";
			break;
		case 'icon6':
			iconPath = iconPath + "newgrounds";
			break;
	}
	
	if (makeSelection)
		iconPath = iconPath + "_hover.jpg";
	else
		iconPath = iconPath + ".jpg";
		
	document.getElementById(iconID).src = iconPath;
}

function showLettersLeft(textID, lableID)
{
	var textArea = document.getElementById(textID);
	var lable = document.getElementById(lableID);
	var lettersLeft = 0;
	var text = textArea.value;
	var textLength = 0;
	
	for (var i = 0; i < text.length; i++)
	{
		textLength++;
		
		var char = text.charAt(i);
		
		if (char.match(/\n/))
			textLength ++;
	}
	
	lettersLeft = textArea.maxLength - textLength;
	lable.innerHTML = (lettersLeft>0?lettersLeft:"No") + " letter" + (lettersLeft!=1?"s":"") + " left";
}

function displayError(errorNum)
{
	var error = document.getElementById('errorContent');
	document.getElementById('errorTitle').style.visibility = 'visible';
	document.getElementById('errorTitle').innerHTML = 'Errors:';
	
	switch (errorNum)
	{
		case 0:
		error.innerHTML = "<ol><li type='circle'>All fields are required to be filled.</li></ol>";
		break;
		
		case 1:
		error.innerHTML = "<ol><li type='circle'>Please provide a valid email address.</li></ol>";
		break;
		
		case 2:
		error.innerHTML = "<ol><li type='circle'>Please check the captcha.</li></ol>";
		break;
		
		case 3:
		error.innerHTML = "<ol><li type='circle'>Captcha verification has failed!</li></ol>";
		break;
	}
	
	error.style.visibility = 'visible';
	error.style.marginBottom = '20px';
}

function displayComment(cmName, cmDate, cmContent)
{
	var box = document.getElementById('commentBox');
	
	box.innerHTML += '<div class="commentHeader"><div class="commenterName"><font color="ee3434">'
	 + cmName + '</font> said:</div><div class="commentDate">'
	 + cmDate + '</div></div><div style="width: 750px; margin-right: auto; margin-left: auto;"><div class="commentContent">'
	 + placeEmos(cmContent.slice(1, cmContent.length - 1)) + '</div></div><div class="commentSeparator"></div>';
}

function displayPost(title, content)
{
	var element = document.getElementById("postsBody");

	element.innerHTML += '<div class="postContainer"><div class="postHeader"><div class="postHeaderTitle">'
	 + title + '</div><div class="postHeaderSeparator"></div></div><div class="postBody"><div class="postBodyContent">'
	 + content.slice(1, content.length - 1) + '</div></div></div>';
}

function submitButtonOver(buttonID)
{
	var button = document.getElementById(buttonID);
	
	button.style.border = '1px solid #ee3434';
	button.style.backgroundColor = '#fff';
	button.style.color = '#ee3434';
}

function submitButtonOut(buttonID)
{
	var button = document.getElementById(buttonID);
	
	button.style.border = '';
	button.style.backgroundColor = '';
	button.style.color = '';
}

function getEmo(emoText)
{
	//Determine if emoText is tag [smile] or icon :)
	var isTag = (emoText.substr(0, 1) == "[" && emoText.substr(emoText.length - 1, 1) == "]");

	if (isTag)
		return ('<img src="images/emoticons/' + emoText.substr(1, emoText.length - 2) + '.png" style="margin-bottom: -3px;"/>');

	var emoName = "";

	switch (emoText)
	{
		case ":|":
			emoName = "ambivalent";
			break;
		case "X(":
		case "x(":
			emoName = "angry";
			break;
		case ":S":
		case ":s":
			emoName = "confused";
			break;
		case "/:)":
			emoName = "content";
			break;
		case "B)":
			emoName = "cool";
			break;
		case ";P":
		case ";p":
			emoName = "crazy";
			break;
		case ":'(":
			emoName = "cry";
			break;
		case "(:(":
			emoName = "embarrassed";
			break;
		case "<:(":
			emoName = "footinmouth";
			break;
		case ":(":
			emoName = "frown";
			break;
		case ":o":
		case ":O":
			emoName = "gasp";
			break;
		case ":D":
			emoName = "grin";
			break;
		case "<3":
			emoName = "heart";
			break;
		case "&)":
			emoName = "hearteyes";
			break;
		case "o:)":
		case "O:)":
			emoName = "innocent";
			break;
		case ":*":
			emoName = "kiss";
			break;
		case ":))":
			emoName = "laughing";
			break;
		case ":<":
			emoName = "minifrown";
			break;
		case ":>":
			emoName = "minismile";
			break;
		case ":$":
			emoName = "moneymouth";
			break;
		case "3:)":
			emoName = "naughty";
			break;
		case "8)":
			emoName = "nerd";
			break;
		case "':/":
			emoName = "notamused";
			break;
		case ";D":
			emoName = "sarcastic";
			break;
		case ":X":
		case ":x":
			emoName = "sealed";
			break;
		case ":/":
			emoName = "slant";
			break;
		case ":)":
			emoName = "smile";
			break;
		case "(n)":
			emoName = "thumbsdown";
			break;
		case "(y)":
			emoName = "thumbsup";
			break;
		case ";)":
			emoName = "wink";
			break;
		case ":p":
		case ":P":
			emoName = "yuck";
			break;
		case ":b":
			emoName ="yum";
			break;
	}

	return ('<img src="images/emoticons/' + emoName + '.png" style="margin-bottom: -3px;"/>');
}

function placeEmos(comment)
{
	if(comment.trim() == "")
		return "";
	
	var foundIndex = 0, lastIndex = 0, prevChar = 0, nextChar = 0, foundLength = 0, leftEndFlag = false, rightEndFlag = false, tagFlag = false, totalLength = comment.length, i;
	var emos = ["[ambivalent]", "[angry]", "[confused]", "[content]", "[cool]", "[crazy]", "[cry]", "[embarrassed]",
	"[footinmouth]", "[frown]", "[gasp]", "[grin]", "[heart]", "[hearteyes]", "[innocent]", "[kiss]", "[laughing]",
	"[minifrown]", "[minismile]", "[moneymouth]", "[naughty]", "[nerd]", "[notamused]", "[sarcastic]", "[sealed]",
	"[slant]", "[smile]", "[thumbsdown]", "[thumbsup]", "[wink]", "[yuck]", "[yum]", ":|", "X(", "x(", ":S", ":s", "/:)",
	"B)", ";p", ";P", ":'(", "(:(", "<:(", ":(", ":o", ":O", ":D", "<3", "&)", "o:)", "O:)", ":*", ":))", ":<", ":>",
	":$", "3:)", "8)", "':/", ";D", ":x", ":X", ":/", ":)", "(n)", "(y)", ";)", ":p", ":P", ":b"];

	for(i = 0; i < emos.length; i++)
	{
		lastIndex = 0;
		foundIndex = 0;
		prevChar = 0;
		nextChar = 0;
		foundLength = 0;
		leftEndFlag = false;
		rightEndFlag = false;
		tagFlag = false;

		while(foundIndex > -1)
		{
			foundIndex = comment.indexOf(emos[i], lastIndex);
			
			if(foundIndex == -1)
				break;

			foundLength = emos[i].length;
			nextChar = foundIndex + foundLength;
			prevChar = foundIndex - 1;

			if(nextChar + 1 > totalLength)
				nextChar = -1;

			if(emos[i].substr(0, 1) == "[")
				tagFlag = true;

			if(prevChar < 0 || comment.substr(prevChar, 1) == " " || ((foundIndex > 4) && (comment.substr(prevChar - 4, 5) == "<br/>")))
				leftEndFlag = true;

			if(nextChar == -1 || comment.substr(nextChar, 1) == " " || ((nextChar + 4 <= totalLength) && (comment.substr(nextChar, 5) == "<br/>")))
				rightEndFlag = true;
			
			if(tagFlag || (leftEndFlag && rightEndFlag))
			{
				var emoCode = getEmo(emos[i]);
				comment = comment.replace(emos[i], emoCode);
				lastIndex = foundIndex + (emoCode.length - foundLength) + 1;
				totalLength = comment.length;
				leftEndFlag = false;
				rightEndFlag = false;
				tagFlag = false;
			}
		}
	}

	return comment;
}