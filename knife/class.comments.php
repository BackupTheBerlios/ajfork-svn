<?php

#
#	Comment storage abstraction class
#



class KComments {

	#
	#	Construct a list of all available comments
	function allcomments($limit="FALSE") {
			$commentsclass = new CommentStorage('comments');
			$allcomments = $commentsclass->settings;
		
			return $allcomments;
		}
	
	#
	#	Get a specific articles comments
	function articlecomments($timestamp) {
			$allcomments = KComments::allcomments();
			$articlecomments = $allcomments[$timestamp];
			return $articlecomments;
		}
		
	function articlecommentsdelete($article) {
		$commentsclass = new CommentStorage('comments');
		if (!is_array($article)) {
			$commentsclass->deleteall($article);
			return true;
			}
		else {
			foreach ($article as $null => $thisid) {
				$commentsclass->deleteall($thisid);
				}
			return true;
			}
		}
	
	function getcomment($article, $comment) {
			$comments = KComments::articlecomments($article);
			$comment = $comments[$comment];
			return $comment;
			}
			
	function add($data) {
	
		}
}

?>