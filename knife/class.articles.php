<?php

#
#	Articles class
#



class KArticles {
		
	function add($author) {
		
		# Get current time
		$now = time();
		
		# Remove dangerous stuff
		$_POST[article][content] = sanitize_variables($_POST[article][content]);
		$_POST[article][title] = sanitize_variables($_POST[article][title]);
		$_POST[article][category] = sanitize_variables($_POST[article][category]);
		
		# Implode the category array
		$savecats = implode(", ", $_POST[article][category]);

		# Enter it all into an array for use later
		$data = array(
			"timestamp" => $now,
			"content" 	=> stripslashes($_POST[article][content]),
			"title" 	=> stripslashes($_POST[article][title]),
			"author" 	=> stripslashes($author),
			"category" 	=> stripslashes($savecats),
			);
			
		# hook to add custom fields here.
		#	$data = run_filters('admin-new-savedata', $data);
	
	
#########------------------------------------------------------------\
#		#	If Storage method is MYSQL:
#########
		
		if (defined("KNIFESQL")) {
		
			$mysql_id = mysql_connect(KNIFE_SQL_SERVER, KNIFE_SQL_USER, KNIFE_SQL_PASSWORD);
			mysql_select_db(KNIFE_SQL_DATABASE, $mysql_id);
			
			$write_sql = "INSERT INTO articles VALUES ('$data[timestamp]', '$data[category]', '$data[author]', '$data[title]', '$data[content]', '1')";
			$result = mysql_query($write_sql) or die('Query failed: ' . mysql_error());
			$statusmessage = i18n("generic_article"). " &quot;$data[title]&quot; ". i18n("write_published");
			return $statusmessage;
			}
		
#########------------------------------------------------------------\
#		#	If Storage method is assoc.array:
#########
		else {
			$dataclass = new ArticleStorage('storage');
			$dataclass->settings['articles'][$now] = $data;
			$dataclass->save();

			# Give the user a status message
			$statusmessage = i18n("generic_article"). " &quot;$data[title]&quot; ". i18n("write_published");
			return $statusmessage;
			}
		}
	
	function delete($data) {
	
		}
	
	
	function listarticles() {
		if (defined("KNIFESQL")) {
			$mysql_id = mysql_connect(KNIFE_SQL_SERVER, KNIFE_SQL_USER, KNIFE_SQL_PASSWORD);
			mysql_select_db(KNIFE_SQL_DATABASE, $mysql_id);
			
			$mysql_query = 'SELECT * FROM `articles`';
			$result = mysql_query($mysql_query) or die('Query failed: ' . mysql_error());
			while ($article = mysql_fetch_assoc($result)) {
				$allarticles["$article[articleid]"] = $article;
				}
			
			return $allarticles;
			}
		else {
			$articledatabase = new ArticleStorage('storage');
			$allarticles = $articledatabase->settings['articles'];
		
			return $allarticles;
			}
		}
	
	function getarticle($timestamp) {
			$allarticles = KArticles::listarticles();
			$article = $allarticles[$timestamp];
			return $article;
		}
}

?>