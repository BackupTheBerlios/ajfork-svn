<?php
/*
Languagefile: Greek
Language Name: Ελληνικά
Author: Spyros Vlachopoulos
Author URI:	http://www.outofthelair.com/
Author Email: outofthelair@outofthelair.com
For Version: 168
*/

## shows.inc.php
$lang_floodprot = 'Η προστασία δημοσίευσης του ίδιου σχόλιου είναι ενεργοποιημένη - θα πρέπει να περιμένετε ' . htmlentities($config_flood_time) . ' δευτερόλεπτα μετά από δημοσίευση του κάθε σχόλιου για να δημοσιεύσετε και πάλι..';
$lang_blocked = 'Μας συγχωρείτε αλλά το ip σας έχει αποκλιστεί από την δημοσιύεση σχόλιων.';
$lang_commentregistered = 'Το όνομα αυτό υπάρχει ήδη, παρακαλούμε δώστε τον κωδικό προς απόδειξη της ταυτότητάς σας.';
$lang_commentregisteredbutton = 'Αποθήκευση σχόλιου';
$lang_onlyregistered = 'Μας συγχωρείτε αλλά μόνο εγγεγραμμένα μέλη μπορούν να δημοσιεύσουν σχόλια και το ' . htmlentities($name) . ' δεν είναι εγγεγραμμένο μέλος.';
$lang_comment_needname = 'Πρέπει να δώσετε όνομα..<br /><a href="javascript:history.go(-1)">επιστροφή</a>';
$lang_comment_invalidmail = 'Δώσατε μή έγγυρη διεύθυνση e-mail.<br /><a href="javascript:history.go(-1)">επιστροφή</a>';
$lang_comment_needvalidmail = 'Δεν δώσατε έγγυρο e-mail  ή URL.<br /><a href="javascript:history.go(-1)">επιστροφή</a>';
$lang_comment_notblank = 'Το πεδίο σχόλιων δεν μπορεί να είναι άδειο.<br /><a href="javascript:history.go(-1)">επιστροφή</a>';
$lang_article_notfound = 'Αδύνατη η εύρεση άρθρου με ταυτότητα: <strong>' . htmlentities($id) . '</strong>';
$lang_article_linktext = 'Κάνετε κλικ εδώ για σχόλια';
$lang_archive_notopen = 'Αδύνατο το άνοιγμα το φακέλου ' . htmlentities($cutepath) . '/data/archives';

## search.php
$lang_search_header = "Εύρεση...";
$lang_search_news = "Άρθρο";
$lang_search_title = "Τίτλος";
$lang_search_author = "Γράφτηκε από";
$lang_search_from = "Εύρεση από";
$lang_search_to = "Εύρεση σε";
$lang_search_archives = "Εύρεση στα αρχεία";
$lang_search_advanced = "Για προχωρημένους..";
$lang_search_cnoarch = "Αδύνατο το άνοιγμα του " . htmlentities($cutepath) . "/data/archives";
$lang_search_found = "<strong>Βρέθηκαν άρθρα που ταιριάζουν στο ερώτημά σας!</strong><br />";
$lang_search_founddate = " ";
$lang_search_notfound = "<strong>Δεν</strong> βρέθηκαν άρθρα που να ταιρίαζουν με το ερώτημά σας.";
$lang_search_button = "Εύρεση!";

## Date
$lang_and = "και";
$lang_dates = array(
	year => "χρόνος",
	month => "μήνας",
	week => "εβδομάδα",
	day => "ημέρα",
	hour => "ώρα",
	minute => "λεπτό",
	second => "δευτερόλεπτο",
	
		plural => 
			array(
				year => "χρόνια",
				month => "μήνες",
				week => "εβδομάδες",
				day => "μέρες",
				hour => "ώρες",
				minute => "λεπτά",
				second => "δευτερόλεπτα",
				),
		);

$lang_days = array(
	monday => "δευτέρα",
	tuesday => "τρίτη",
	wednesday => "τετάρτη",
	thursday => "πέμπτη",
	friday => "παρασκεύη",
	saturday => "σάββατο",
	sunday => "κυριακή",
);

$lang_months = array(
	january => "ιανουαρίου",
	february => "φεβρουαρίου",
	march => "μαρτίου",
	april => "απριλίου",
	may => "μαΐου",
	june => "ιουνίου",
	july => "ιουλίου",
	august => "αυγούστου",
	september => "σεπτεμβρίου",
	october => "οκτωβρίου",
	november => "νοεμβρίου",
	december => "δεκεμβρίου",
	);
?>
