<?php
include("./inc/functions.inc.php");
header("Content-Type: text/xml;");
$host = $_SERVER['REMOTE_ADDR'];
$id = $_GET['id'];
$furls_date = $_GET['furls_date'];

/* ID STUFF */

if (preg_match('/[a-z]/', $id) == 0) {
	$all_active_news = file("./data/news.txt");
	
	foreach($all_active_news as $null => $active_news) {	
	        $news_arr = explode("|", $active_news);
        	if (aj_prepareTitle($id) == aj_prepareTitle($news_arr[2]) and ($furls_date == date("Y/m/d", $news_arr[0]))) {
			$id = $news_arr[0];
			}
		}
	}

/* END ID */

$tb_title = strip_tags($_POST['title']);
$tb_excerpt = strip_tags($_POST['excerpt']);
$tb_url = strip_tags($_POST['url']);
$tb_url = str_replace("&","&amp;",$tb_url);
$tb_blog_name = strip_tags($_POST['blog_name']);
if (empty($id) || empty($tb_title) || empty($tb_excerpt) || empty($tb_url) || empty($tb_blog_name))
{
	trackback_response(1,'At least one of the required fields is missing.');
}
include ('inc/plugins.php');
$xfclass = new XFieldsData();
$disabled = $xfclass->fetch($id,'tbs_disabled');
if ($disabled == "yes")
{
	trackback_response(1,"Trackbacks have been disabled for this post");
}
$time = time();
$data = array('title' => $tb_title, 'excerpt' => $tb_excerpt, 'url' => $tb_url, 'blog_name' => $tb_blog_name, 'host' => $host);
$old_data = $xfclass->fetch($id,'trackbacks');
$old_data[$time] = $data;
$xfclass->set($old_data,$id,'trackbacks');
$xfclass->save();
trackback_response();

function trackback_response($error = 0, $error_message = '') {
	if ($error) {
		echo '<?xml version="1.0" encoding="iso-8859-1"?'.">\n";
		echo "<response>\n";
		echo "<error>1</error>\n";
		echo "<message>$error_message</message>\n";
		echo "</response>";
	} else {
		echo '<?xml version="1.0" encoding="iso-8859-1"?'.">\n";
		echo "<response>\n";
		echo "<error>0</error>\n";
		echo "</response>";
	}
	die();
}
?>
