<?php
/*
Languagefile: Polish
Language Name: Polski
Author: Bartosz Brzezinski
Author URI:	http://fantasy.wot.pl/
Author Email: bartosz_br@yahoo.com
For Version: 168
*/

## shows.inc.php
$lang_floodprot = 'Włączona ochrona przed przeciążeniem- będziesz musiał(a) poczekać ' . htmlentities($config_flood_time) . ' sekund zanim bedziesz mógł(a) dodać nowy komentarz..';
$lang_blocked = 'Niestety, twój adres ip został zablokowany przed komentowaniem.';
$lang_commentregistered = 'To imię zostało zarejestrowane, podaj hasło by potwierdzić, że przez Ciebie.';
$lang_commentregisteredbutton = 'Dodaj komentarz';
$lang_onlyregistered = 'Niestety, dodawać komentarze mogą tylko zarejestrowani użytkownicy, a ' . htmlentities($name) . ' nie jest aktualnie zarejestrowany.';
$lang_comment_needname = 'Musisz podać imię..<br /><a href="javascript:history.go(-1)">Powrót</a>';
$lang_comment_invalidmail = 'Podałeś(aś) nieprawidłowy adres e-mailowy.<br /><a href="javascript:history.go(-1)">Powrót</a>';
$lang_comment_needvalidmail = 'Nie podałeś(aś) poprawnego adresu e-mailowego lub adresu twojej strony internetowej.<br /><a href="javascript:history.go(-1)">Powrót</a>';
$lang_comment_notblank = 'Pole z komentarzem nie może pozostać puste.<br /><a href="javascript:history.go(-1)">Powrót</a>';
$lang_comment_notaccepted = 'Niestety, w tym momencie nie jest możliwe dodawanie nowych komentarzy.';
$lang_article_notfound = 'Nie znaleziono artykułu o nazwie: <strong>' . htmlentities($id) . '</strong>';
$lang_article_linktext = 'Kliknij tutaj aby skomentować';
$lang_archive_notopen = 'Nie udało się otworzyć katalogu ' . htmlentities($cutepath) . '/data/archives';

## search.php
$lang_search_header = "Szukaj...";
$lang_search_news = "Artykuł";
$lang_search_title = "Tytuł";
$lang_search_author = "Dodane przez";
$lang_search_from = "Szukaj od";
$lang_search_to = "Szukaj do";
$lang_search_archives = "Szukaj w archiwum";
$lang_search_advanced = "Zaawansowane..";
$lang_search_cnoarch = "Nie znaleziono " . htmlentities($cutepath) . "/data/archives";
$lang_search_found = "<strong>Znajdź artykuły dotyczące twojego pytania!</strong><br />";
$lang_search_founddate = " ";
$lang_search_notfound = "Znaleziono <strong>no</strong> artykułów dotyczących twojego pytania.";
$lang_search_button = "Szukaj!";

## Date
$lang_and = "i";
$lang_dates = array(
	year => "rok",
	month => "miesiąc",
	week => "tydzień",
	day => "dzień",
	hour => "godzina",
	minute => "minuta",
	second => "sekunda",
	
		plural => 
			array(
				year => "lata",
				month => "miesiące",
				week => "tygodnie",
				day => "dni",
				hour => "godziny",
				minute => "minuty",
				second => "sekundy",
				),
		);

$lang_days = array(
	monday => "poniedziałek",
	tuesday => "wtorek",
	wednesday => "środa",
	thursday => "czwartek",
	friday => "piątek",
	saturday => "sobota",
	sunday => "niedziela",
);

$lang_months = array(
	january => "styczeń",
	february => "luty",
	march => "marzec",
	april => "kwiecień",
	may => "maj",
	june => "czerwiec",
	july => "lipiec",
	august => "sierpień",
	september => "wrzesień",
	october => "październik",
	november => "listopad",
	december => "grudzień",
	);
?>
