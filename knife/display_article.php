<?php

#
#		File loaded when displaying a single article
#


		$k = $_GET[k];
		if (!$k) { $k = $pathinfo_array[1]; }
		if (eregi("[a-z]", $k)) {
			# if $k is alpha , find the timestamp for this article
			foreach ($allarticles as $timestamp => $article) {
				if (urlTitle($article[title]) == $k) {
					$k = $timestamp;
					break 1;
					}
				}
			}
			
			
		$article = $allarticles[$k];
		if ($article != "") { $valid = true; }
		
		# date can come from two places
		if ($timestamp) {
			$date = $timestamp;
			}
		else {
			$date = $k;
			}
			
		# select the current template
		$output = $template[view];
		# parse the listing template
		
		if (stristr($article[content], "<!--more-->")) {
			$article[content] = explode("<!--more-->", $article[content]);
			
				$article[content][0] = Markdown($article[content][0]);
				$article[content][1] = Markdown($article[content][1]);
			
			$output = str_replace("{content}", $article[content][0], $output);
			$output = str_replace("{extended}", $article[content][1], $output);
			}		
		$output = str_replace("{title}", $article[title], $output);
		
			$article[content] = Markdown($article[content]);
		
		$output = str_replace("{content}", $article[content], $output);
		$output = str_replace("{extended}", "", $output);
		$output = str_replace("{author}", $article[author], $output);
		$output = str_replace("{category}", $article[category], $output);
		$output = str_replace("{date}", date("dmy H:i", $date), $output);

		$article[views] = $KAclass->articleupdate($date, "views", "update");
		$output = str_replace("{views}", $article[views], $output);
		
		echo $output;
		
		
		#
		#	Start showing comments
		#
		
		echo '<div id="Commentscontainer">';
		$articlescomments = $commentsclass->articlecomments($date);
		
	if (!$articlescomments or $articlescomments == "") {
		echo "no comments";
	}
	else {
		krsort($articlescomments);
		reset($articlescomments);
		$i = 1;
		foreach ($articlescomments as $commentid => $comment) {
			$output = $template[comment];
			$output = str_replace("{number}", $i, $output);
			
			if ($comment[parentcid]) {
				$quotecomment = $articlescomments[$comment[parentcid]];
				$quoteout = $template[quote];
				$quoteout = str_replace("{name}", $quotecomment[name], $quoteout);
				$quoteout = str_replace("{quote}", Markdown($quotecomment[content]), $quoteout);
				
				$output = str_replace("{parentquote}", $quoteout, $output);
				}
			else { $output = str_replace("{parentquote}", "", $output); }
			
			$output = str_replace("{comment}", Markdown($comment[content]), $output);
			$output = str_replace("{ip}", $comment[ip], $output);
			$output = str_replace("{author}", $comment[name], $output);
			$output = str_replace("{date}", date("d/m/y H:i", $commentid), $output);
			$output = str_replace("{url}", $comment[url], $output);
			$output = str_replace("{email}", $comment[mail], $output);
			$output .= '<a href="'.$_SERVER[PHP_SELF].'?replyto='.$commentid.'">reply</a>';
			echo $output;
			$i++;
		}
	}
		echo '</div>';
		
		#
		#	If receiving a comment
		#
		
		if ($_POST[comment] && $valid) {
		
		#
		#	Needs i18n-love
		
		if (!$_POST[comment][name] or $_POST[comment][name] == "") {
			$errors .= "<li><p>No name submitted. You'll have to identify yourself, I'm afraid!</p></li>";
			}
		if ($_POST[comment][email] && !preg_match("/^[\.A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $_POST[comment][email])) {
			$errors .= "<li><p>Given email is invalid, a real email is needed</p></li>";
			}
		if (!stristr($_POST[comment][url], "http://")) {
			$errors .= "<li><p>Given url is invalid. Check that it contains the required http:// part</p></li>";
			}
		if (!$_POST[comment][content] or $_POST[comment][content] == "") {
			$errors .= "<li><p>Sorry to break the news to you, but blank comments are quite useless</p></li>";
			}
		
		if (!$errors) {
			$newcommentid = time();
			$savecomment = array(
				'parentcid' => stripslashes($_GET[replyto]),
				'name' => stripslashes($_POST[comment][name]),
				'email' => stripslashes($_POST[comment][email]),
				'url' => stripslashes($_POST[comment][url]),
				'ip' => '127.0.0.1',
				'browser' => 'firefox ofcourse',
				'content' => stripslashes($_POST[comment][content]),
				);
			$commentsclass = new CommentStorage('comments');
			$commentsclass->settings[$date][$newcommentid] = $savecomment;
			$commentsclass->save();
			echo "<script type=\"text/javascript\">self.location.href='http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}';</script>";
			}
			
		else {
			echo "<div id=\"Commentposterror\"><h1>Trouble in the hills!</h1><p>There was a problem processing the material you submitted. The specific problems are detailed below, and you are encouraged to sort out the problems and try again:</p><ol>$errors</ol></div>";
			}
		}
		
		#
		#	Show the comment form
		#
		
		$output = '<form method="post" style="margin-top: 20px; padding: 15px; border: 1px solid #999;">';
		$output .= $template[commentform];
		$output .= '</form>';
		echo $output;
	

		
		?>