<?PHP 

$rss_setup[number] = "15";

$rss_setup[title] = "the title";

$rss_setup[link] = "http://localhost/";

$rss_setup[language] = "no-nb";

$rss_setup[description] = "Description for this rss feed";

$rss_setup[template] = "<item>
<title>{title} [{comments-num}]</title>
<guid isPermaLink=\"false\">{news-id}</guid>
<category>{category}</category>
<link>http://yoursite.org/index.php?aj_go=more&id={news-id}&ucat={category-id}</link>
<description>[CDATA[{short-story}]]</description>
<author>{rssmail}</author>
<dc:author>{rssauthor}</dc:author>
<pubDate>{rssdate}</pubDate>  
</item>";

?>