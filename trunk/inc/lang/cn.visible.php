<?php
/*
Languagefile: Traditional Chinese
Language Name: 繁體中文
Author: F. C. (Mohican)
Author URI: http://cutephp.com/forum/index.php?showuser=631
Author Email: mosey_88@yahoo.com
For Version: 168
*/

## shows.inc.php
$lang_floodprot = '防止flood使用中-請稍等 ' . htmlentities($config_flood_time) . ' 秒再留言.';
$lang_blocked = '對不起,你的IP被禁止在此留言.';
$lang_commentregistered = '此名已註冊了,請提供你的密碼證明你的身份.';
$lang_commentregisteredbutton = '儲存留言';
$lang_onlyregistered = '對不起,只有已註冊的會員才可留言, 而' . htmlentities($name) . ' 沒有註冊.';
$lang_comment_needname = '您必須輸入名字..<br /><a href="javascript:history.go(-1)">前一頁</a>';
$lang_comment_invalidmail = '您輸入了一個無效的電子郵件信箱.<br /><a href="javascript:history.go(-1)">前一頁</a>';
$lang_comment_needvalidmail = '您沒有輸入有效的電子郵件信箱或網址.<br /><a href="javascript:history.go(-1)">前一頁</a>';
$lang_comment_notblank = '留言項目不可留空.<br /><a href="javascript:history.go(-1)">前一頁</a>';
$lang_article_notfound = '此文章: <strong>' . htmlentities($id) . '</strong>不存在';
$lang_article_linktext = '請選此留言';
$lang_archive_notopen = '無法開啟此檔 ' . htmlentities($cutepath) . '/data/archives';

## search.php
$lang_search_header = "搜尋...";
$lang_search_news = "文章";
$lang_search_title = "標題";
$lang_search_author = "作者";
$lang_search_from = "從_搜尋";
$lang_search_to = "搜尋到";
$lang_search_archives = "搜尋被歸檔的文章";
$lang_search_advanced = "進階..";
$lang_search_cnoarch = "無法開啟 " . htmlentities($cutepath) . "/data/archives";
$lang_search_found = "<strong>搜尋結果!</strong><br />";
$lang_search_founddate = " ";
$lang_search_notfound = "有 <strong>0</strong> 文章符合您的關鍵字.";
$lang_search_button = "搜尋!";

## Date
$lang_and = "而";
$lang_dates = array(
year => "年",
month => "月",
week => "週",
day => "日",
hour => "小時",
minute => "分",
second => "秒",

 plural =>
  array(
   year => "年",
   month => "月",
   week => "週",
   day => "日",
   hour => "小時",
   minute => "分",
   second => "秒",
   ),
	);

$lang_days = array(
monday => "星期一",
tuesday => "星期二",
wednesday => "星期三",
thursday => "星期四",
friday => "星期五",
saturday => "星期六",
sunday => "星期日",
);

$lang_months = array(
january => "一月",
february => "二月",
march => "三月",
april => "四月",
may => "五月",
june => "六月",
july => "七月",
august => "八月",
september => "九月",
october => "十月",
november => "十一月",
december => "十二月",
);
?>
