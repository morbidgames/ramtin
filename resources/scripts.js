// JavaScript Document

window.onscroll = function() {scrollTabsPlacement()};
document.onmousewheel = function() {scrollTabsPlacement()};

function keyNavigateToSearch(e, elementId)
{
	if(e.keyCode == 13) navigateToSearch(elementId);
}

function navigateToSearch(elementId)
{
	element = document.getElementById(elementId);

	if(element.value.trim().replace(/\s+/g, '') == "") return;
	
	location.href = 'search.php?key=' + encodeURIComponent(element.value.trim().replace(/\s+/g, ' ')).replace(/%20/g, '+') + '&sort=best&page=1';
}

function insertFormatTag(formatType, commentBox)
{
	var cmBox = document.getElementById(commentBox);
	var preStart = cmBox.selectionStart, preEnd = cmBox.selectionEnd;

	if (((formatType.length * 2) + 5 + cmBox.value.length) > cmBox.maxLength)
		return;

	cmBox.value = cmBox.value.slice(0, cmBox.selectionStart) +
	 "[" + formatType + "]" +
	 cmBox.value.substr(cmBox.selectionStart, cmBox.selectionEnd - cmBox.selectionStart) +
	 "[/" + formatType + "]" +
	 cmBox.value.slice(cmBox.selectionEnd, cmBox.value.length);

	if(preStart == preEnd)
		cmBox.selectionStart = (cmBox.selectionEnd = (preStart + formatType.length + 2));

	showLettersLeft('comments', 'lettersCount');
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

	if (emoTag.length + 2 + cmBox.value.length > cmBox.maxLength)
		return;

	cmBox.value = cmBox.value.slice(0, cmBox.selectionStart) + "[" + emoTag + "]" + cmBox.value.slice(cmBox.selectionEnd, cmBox.value.length);

	showLettersLeft(commentBox, 'lettersCount');
}

function scrollTabsPlacement()
{
	if (window.pageYOffset > 187)
		document.getElementById("headerFollowup").style.visibility = "visible";
	else
		document.getElementById("headerFollowup").style.visibility = "hidden";
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
		case 4:
			error.innerHTML = "<ol><li type='circle'>Comment contains no valid text.</li></ol>";
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

function displayPost(title, date, author, content, tags, peak, id)
{
	if (peak === undefined) peak = false;

	if (id === undefined) id = 0;

	if (tags === undefined)
		tags = [];
	else
	{
		tags = JSON.parse(tags);

		if (tags[0] == "") tags.splice(0, 1);
	}

	var element = document.getElementById("postsBody");
	var finalPost = "";

	finalPost = '<div class="postContainer"><div class="postHeader"><div class="postHeaderTitle">'
	 + title + '</div><div class="postHeaderSeparator"></div></div><div class="postInfo">By '
	 + author + ', on ' + date +'</div><div class="postBody"><div class="postBodyContent">'
	 + content.slice(1, content.length - 1) + (peak?(' <a href="/post.php?id=' + id + '">Read more...</a>'):'') + (tags.length > 0?'<div class="tagsWrapper">':'');

	for (var i = tags.length - 1; i >= 0; i--)
		finalPost += '<a href="tag.php?tag=' + tags[i] + '&sort=recent&page=1"><div class="tag">' + tags[i] + '</div></a>';

	finalPost += (tags.length > 0?'</div>':'') + '</div></div></div>';

	element.innerHTML += finalPost;
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
			else
				tagFlag = false;

			if(prevChar < 0 || comment.substr(prevChar, 1) == " " || ((foundIndex > 4) && (comment.substr(prevChar - 4, 5) == "<br/>")))
				leftEndFlag = true;
			else
				leftEndFlag = false;

			if(nextChar == -1 || comment.substr(nextChar, 1) == " " || ((nextChar + 4 <= totalLength) && (comment.substr(nextChar, 5) == "<br/>")))
				rightEndFlag = true;
			else
				rightEndFlag = false;
			
			if(tagFlag || (leftEndFlag && rightEndFlag))
			{
				var emoCode = getEmo(emos[i]);
				
				comment = comment.substr(0, foundIndex) + emoCode + comment.substr(nextChar, comment.length - nextChar);
				lastIndex = foundIndex + emoCode.length;
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
	// Return if empty comment
	if(comment.trim() == "")
		return "";

	// Define all needed variables
	var foundStartIndex = 0, foundEndIndex = 0, lastStartIndex = 0, lastEndIndex = 0, dif = 0, difCounter = 0;
	var starts = [], ends = [], markedIndexes = [];
	var loop = true;

	// Search for all openSyntax and closeSyntax tags in comment
	while(loop)
	{
		foundStartIndex = comment.indexOf(openSyntax, lastStartIndex);
		foundEndIndex = comment.indexOf(closeSyntax, lastEndIndex);

		// If foundStartIndex was found, add it to starts array
		if(foundStartIndex > -1)
		{
			starts.push(foundStartIndex);
			lastStartIndex = foundStartIndex + 1;
		}

		// If foundEndIndex was found, add it to ends array
		if(foundEndIndex > -1)
		{
			ends.push(foundEndIndex);
			lastEndIndex = foundEndIndex + 1;
		}

		// If both were not found at the same time, exit loop
		if(foundEndIndex == -1 && foundStartIndex == -1)
			loop = false;
	}

	// Mark all valid tags, any invalid tags will be left out (invalid tags are non-closed open tags or non-opened close tags)
	// Loop for open tags backward in starts array, and for close tags forward in ends array
	for(var i = starts.length - 1; i >= 0; i--)
	{
		if(ends.length == 0)
			break;

		for(var j = 0; j < ends.length; j++)
		{
			// Select the nearest end tag to start tag (index of end tag should always be greater than start tag, otherwise it doesn't belong to start tag)
			if(starts[i] < ends[j])
			{
				markedIndexes.push(starts[i]);
				markedIndexes.push(ends[j]);

				ends.splice(j, 1);
				starts.splice(i, 1);
				
				break;
			}
		}
	}

	// The markedIndexes array now follows this pattern: [openTag2, closeTag1, openTag1, closeTag2]
	// Therefore, we loop backward for open tag with i beginning at length - 2, and i -= 2 on each loop
	// And, loop forward for close tags with i beginning at 1, and i += 2 on each loop

	// When replacing tags with HTML tags, the index of the next tag should increment by the difference between old and new tags in length (+1 for the space after each HTML tag)
	dif = openHTML.length - openSyntax.length;

	// Replace all marked open tags
	for(var i = markedIndexes.length - 2; i >= 0; i -= 2)
	{
		// Calculate total difference at this point and add it to next index
		markedIndexes[i] += (dif + 1) * difCounter;

		comment = comment.substr(0, markedIndexes[i]) + openHTML + ' ' + comment.substr(markedIndexes[i] + openSyntax.length, comment.length - (markedIndexes[i] + openSyntax.length));

		difCounter++;
	}

	// For the next loop, the dif should be the difference of close tags + total difference (index shiftings) in the previous loop
	var totalOpenDif = (dif + 1) * difCounter;

	difCounter = 0;
	dif = closeHTML.length - closeSyntax.length;

	// Replace all marked close tags
	for(var i = 1; i < markedIndexes.length; i += 2)
	{
		markedIndexes[i] += ((dif + 1) * difCounter) + totalOpenDif;

		comment = comment.substr(0, markedIndexes[i]) + closeHTML + ' ' + comment.substr(markedIndexes[i] + closeSyntax.length, comment.length - (markedIndexes[i] + closeSyntax.length));

		difCounter++;
	}

	// Any other tags left out of markedIndexes are invalid and should be removed from text
	var openTemp = openSyntax.replace("[", "\\[").replace("]", "\\]");
	var closeTemp = closeSyntax.replace("[", "\\[").replace("]", "\\]");

	var openRegex = new RegExp(openTemp, 'g');
	var closeRegex = new RegExp(closeTemp, 'g');

	comment = comment.replace(openRegex, '');
	comment = comment.replace(closeRegex, '');

	return comment;
}