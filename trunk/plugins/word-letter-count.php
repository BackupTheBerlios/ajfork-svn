<?php

/*
Plugin Name: Word and Letter Count
Plugin URI: http://www.jubbag.com
Description: Counts the words and letters of the long and short stories for an entry and makes the tags {word-count} and {word-count-short}, and {letter-count} and {letter-count-short}.
Version:  0.1
Author:   J-Dawg
Author URI:  http://www.jubbag.com
Application: CuteNews
Required Framework: 1.0.0
*/
@add_filter('news-entry','word_count');
@add_filter('news-entry','letter_count');

function word_count($entry,$hook)
{
global $news_arr;
$content = explode('<!--more-->', $news_arr[3]);
$preparedfullstory0 = strip_tags($content[1]);
$preparedfullstory1 = explode(" ", $preparedfullstory0);
$wordcount = count($preparedfullstory1);
$entry = str_replace("{word-count}", $wordcount, $entry);

$preparedfullstory2 = strip_tags($content[0]);
$preparedfullstory3 = explode(" ", $preparedfullstory2);
$wordcountshort = count($preparedfullstory3);
$entry = str_replace("{word-count-short}", $wordcountshort, $entry);
return $entry;
}

function letter_count($entry,$hook)
{
global $news_arr;
   $content = explode('<!--more-->', $news_arr[3]);
   $preparedfull = strip_tags($content[1]);
   $preparedfull1 = str_replace(" ", "", $preparedfull);
   $lettercountfull = strlen($preparedfull1);
   $entry = str_replace("{letter-count}", $lettercountfull, $entry);
   $preparedshort = strip_tags($content[0]); //Short Story
   $preparedshort1 = str_replace(" ", "", $preparedshort);
   $lettercountshort = strlen($preparedshort1);
   $entry = str_replace("{letter-count-short}", $lettercountshort, $entry);
return $entry;
}

?>
