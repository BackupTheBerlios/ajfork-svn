<?php
/*
Languagefile: Russian
Language Name: Русский
Author: Tim Power (plecido)
Author URI:	http://njoy.org
Author Email: root@njoy.org
For Version: 168
*/

## shows.inc.php
$lang_floodprot = 'Активирована опция Защиты от флуда. Вам прийдётся подождать ' . htmlentities($config_flood_time) . ' секунд прошло с Вашего последнего комментария.<br />Вам прийдётся подождать перед тем как оставить новый комментарий.';
$lang_blocked = 'Извините, но Ваш ip-адрес был заблокирован системой.<br />Вы не можете оставить свой комментарий.';
$lang_commentregistered = 'Это имя является зарегистрированным.<br />Вам следует ввести пароль для идентификации.';
$lang_commentregisteredbutton = 'Оставить комментарий';
$lang_onlyregistered = 'Извините, но только зарегистрированные пользователи могут оставлять комментарии, а ' . htmlentities($name) . ' не является зарегистрированным.';
$lang_comment_needname = 'Вам следует ввести своё имя.<br /><a href="javascript:history.go(-1)">Возвратиться</a>';
$lang_comment_invalidmail = 'Вы ввели не корректный email адрес.<br /><a href="javascript:history.go(-1)">Возвратиться</a>';
$lang_comment_needvalidmail = 'Вы ввели не корректный email или ссылку.<br /><a href="javascript:history.go(-1)">Возвратиться</a>';
$lang_comment_notblank = 'Поле комментария не может быть пустым.<br /><a href="javascript:history.go(-1)">Возвратиться</a>';
$lang_comment_notaccepted = 'Извините, но комментарии больше не принимаются.';
$lang_article_notfound = 'Не удалось найти статью с id: <strong>' . htmlentities($id) . '</strong>';
$lang_article_linktext = 'Комментировать';
$lang_archive_notopen = 'Не удалось открыть папку ' . htmlentities($cutepath) . '/data/archives';

## search.php
$lang_search_header = "Поиск...";
$lang_search_news = "Статья";
$lang_search_title = "Название";
$lang_search_author = "Автор";
$lang_search_from = "Искать с";
$lang_search_to = "Искать до";
$lang_search_archives = "Искать в архивах";
$lang_search_advanced = "Дополнительно";
$lang_search_cnoarch = "Не удалось открыть " . htmlentities($cutepath) . "/data/archives";
$lang_search_found = "<strong>По Вашему запросу были найдены следующие статьи :</strong><br />";
$lang_search_founddate = " ";
$lang_search_notfound = "По Вашему запросу ничего найдено не было.";
$lang_search_button = "Поиск!";

## Date
$lang_and = "и";
$lang_dates = array(
	year => "год",
	month => "месяц",
	week => "неделя",
	day => "день",
	hour => "час",
	minute => "минута",
	second => "секунда",
	
		plural => 
			array(
				year => "годов",
				month => "месяцев",
				week => "недель",
				day => "дней",
				hour => "часов",
				minute => "минут",
				second => "секунд",
				),
		);

$lang_days = array(
	monday => "понедельник",
	tuesday => "вторник",
	wednesday => "среда",
	thursday => "четверг",
	friday => "пятница",
	saturday => "суббота",
	sunday => "воскресенье",
);

$lang_months = array(
	january => "январь",
	february => "февраль",
	march => "март",
	april => "апрель",
	may => "май",
	june => "июнь",
	july => "июль",
	august => "август",
	september => "сентябрь",
	october => "октябрь",
	november => "ноябрь",
	december => "декабрь",
	);
?>
