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
		$output = str_replace("{link}", "<a href=\"?k=$date\" title=\"$article[title]\">Read</a>", $output);

		$article[views] = $KAclass->articleupdate($date, "views", "update");
		$output = str_replace("{views}", $article[views], $output);
		
		echo $output;
		
		echo '<div id="commentshere">';
		$commentsclass = new CommentStorage('comments');
		$articlescomments = $commentsclass->settings[$date];
		
	if (!$articlescomments or $articlescomments == "") {
		echo "no comments";
	}
	else {
	
		foreach ($articlescomments as $commentid => $comment) {
			echo "<p>".date("dmyH:i", $commentid)."<br />name: $comment[name]<br />
			url: $comment[url]<br />
			ip: $comment[ip]<br />
			comment: $comment[content]</p>";
		}
	}
		echo '</div>';
		
		$output = '
		<form method="post" style="margin-top: 20px; padding: 15px; border: 1px solid #999;">
		<input type="text" name="comment[name]" /> Name<br />
		<input type="text" name="comment[email]" /> Email<br />
		<input type="text" name="comment[url]" /> URL<br /><br />
			
		Comment<br />
		<textarea name="comment[content]" rows="7" cols="50"></textarea><br />
		<input type="submit" value="Add comment"/>
		</form>';
		
		echo $output;
		
		if ($_POST[comment]) {
		
		$newcommentid = time();
		$savecomment = array(
			'parentcid' => $_POST[comment][parent],
			'name' => $_POST[comment][name],
			'email' => $_POST[comment][email],
			'url' => $_POST[comment][url],
			'ip' => '127.0.0.1',
			'browser' => 'firefox ofcourse',
			'content' => $_POST[comment][content],
			);
			
		$commentsclass->settings[$date][$newcommentid] = $savecomment;
		$commentsclass->save();
		echo "<script type=\"text/javascript\">self.location.href='http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}';</script>";
		}
		
		?>