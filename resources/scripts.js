// JavaScript Document

window.onscroll = function() {scrollTabsPlacement()};
document.onmousewheel = function() {scrollTabsPlacement()};

function insertFormatTag(formatType, commentBox)
{
	var cmBox = document.getElementById(commentBox);
	var preStart = cmBox.selectionStart, preEnd = cmBox.selectionEnd;

	cmBox.value = cmBox.value.slice(0, cmBox.selectionStart) +
	 "[" + formatType + "]" +
	 cmBox.value.substr(cmBox.selectionStart, cmBox.selectionEnd - cmBox.selectionStart) +
	 "[/" + formatType + "]" +
	 cmBox.value.slice(cmBox.selectionEnd, cmBox.value.length);

	if(preStart == preEnd)
		cmBox.selectionStart = (cmBox.selectionEnd = (preStart + formatType.length + 2));
}

function formatShortcut(e, commentBox)
{
	var eventObj = window.event?event:e;
	var unicode = eventObj.charCode?eventObj.charCode:eventObj.keyCode;
	var keyChar = String.fromCharCode(unicode);

	if(keyChar == "A" && eventObj.altKey)
		insertFormatTag('bold', commentBox);
	else if(keyChar == "I" && eventObj.altKey)
		insertFormatTag('italic', commentBox);
}

function switchEmoBox()
{
	var element = document.getElementById('emoBox');
	var show = (element.offsetHeight == 0);

	if(show)
	{
		element.style.height = "52px";
		element.style.opacity = "1";
		element.style.marginBottom = "10px";
	}
	else
	{
		element.style.height = "0px";
		element.style.opacity = "0";
		element.style.marginBottom = "0px";
	}
}

function insertEmo(emoTag, commentBox)
{
	var cmBox = document.getElementById(commentBox);

	cmBox.value = cmBox.value.slice(0, cmBox.selectionStart) + "[" + emoTag + "]" + cmBox.value.slice(cmBox.selectionEnd, cmBox.value.length);
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
	var finalComment = cmContent.slice(1, cmContent.length - 1);
	finalComment = stylizeText(finalComment, "[bold]", "[/bold]", "<strong>", "</strong>");
	finalComment = stylizeText(finalComment, "[italic]", "[/italic]", "<em>", "</em>");
	finalComment = placeEmos(finalComment);
	
	box.innerHTML += '<div class="commentHeader"><div class="commenterName"><font color="ee3434">'
	 + cmName + '</font> said:</div><div class="commentDate">'
	 + cmDate + '</div></div><div style="width: 750px; margin-right: auto; margin-left: auto;"><div class="commentContent">'
	 + finalComment + '</div></div><div class="commentSeparator"></div>';
}

function displayPost(title, content)
{
	var element = document.getElementById("postsBody");

	element.innerHTML += '<div class="postContainer"><div class="postHeader"><div class="postHeaderTitle">'
	 + title + '</div><div class="postHeaderSeparator"></div></div><div class="postBody"><div class="postBodyContent">'
	 + content.slice(1, content.length - 1) + '</div></div></div>';
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
		case ":&":
			emoName = "sick";
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
	"[minifrown]", "[minismile]", "[moneymouth]", "[naughty]", "[nerd]", "[notamused]", "[sarcastic]", "[sealed]", "[sick]",
	"[slant]", "[smile]", "[thumbsdown]", "[thumbsup]", "[wink]", "[yuck]", "[yum]", ":|", "X(", "x(", ":S", ":s", "/:)",
	"B)", ";p", ";P", ":'(", "(:(", "<:(", ":(", ":o", ":O", ":D", "<3", "&)", "o:)", "O:)", ":*", ":))", ":<", ":>",
	":$", "3:)", "8)", "':/", ";D", ":x", ":X", ":&", ":/", ":)", "(n)", "(y)", ";)", ":p", ":P", ":b"];

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
			else
				lastIndex = foundIndex + emos[i].length;
		}
	}

	return comment;
}

function stylizeText(comment, openSyntax, closeSyntax, openHTML, closeHTML)
{
	if(comment.trim() == "")
		return "";

	var foundStartIndex = 0, foundEndIndex = 0, lastStartIndex = 0, lastEndIndex = 0;
	var starts = [], ends = [];
	var loop = true;
	var dif = openHTML.length - openSyntax.length;

	while(loop)
	{
		foundStartIndex = comment.indexOf(openSyntax, lastStartIndex);
		foundEndIndex = comment.indexOf(closeSyntax, lastEndIndex);

		if(foundStartIndex > -1)
		{
			starts.push(foundStartIndex);
			lastStartIndex = foundStartIndex + 1;
		}

		if(foundEndIndex > -1)
		{
			ends.push(foundEndIndex);
			lastEndIndex = foundEndIndex + 1;
		}

		if(foundEndIndex == -1 && foundStartIndex == -1)
			loop = false;
	}

	for(var i = starts.length - 1; i >= 0; i--)
	{
		if(ends.length == 0)
			break;

		for(var j = 0; j < ends.length; j++)
		{
			if(starts[i] < ends[j])
			{
				comment = comment.substr(0, starts[i]) + openHTML + ' ' + comment.substr(starts[i] + openSyntax.length, comment.length - (starts[i] + openSyntax.length));
				comment = comment.substr(0, ends[j] + 1 + dif) + ' ' + closeHTML + comment.substr(ends[j] + 1 + dif + closeSyntax.length, comment.length - (ends[j] + 1 + dif + closeSyntax.length));
				ends.splice(j, 1);
				starts.splice(i, 1);
				break;
			}
		}
	}

	var openTemp = openSyntax.replace("[", "\\[").replace("]", "\\]");
	var closeTemp = closeSyntax.replace("[", "\\[").replace("]", "\\]");

	var openRegex = new RegExp(openTemp, 'g');
	var closeRegex = new RegExp(closeTemp, 'g');

	comment = comment.replace(openRegex, '');
	comment = comment.replace(closeRegex, '');

	return comment;
}