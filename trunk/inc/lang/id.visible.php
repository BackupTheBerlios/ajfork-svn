<?php
/*
Languagefile: Indonesian
Language Name: Bahasa Indonesia
Author: Anonymous (cwps)
Author URI: http://localhost/
Author Email: cwps@linuxmail.org
For Version: 168
*/

## shows.inc.php
$lang_floodprot = 'Proteksi-Flood di aktifkan - Anda harus menunggu ' . htmlentities($config_flood_time) . ' detik setelah komentar terakhir anda untuk bisa menulis komentar kembali..';
$lang_blocked = 'Maaf, Tidak bisa mengisi komentar karena IP anda sudah kena block.';
$lang_commentregistered = 'Nama ini sudah terdaftar, silahkan isi password untuk membuktikan identitas anda.';
$lang_commentregisteredbutton = 'Simpan komentar';
$lang_onlyregistered = 'Maaf, hanya anggota yang terdaftar yang diperbolehkan mengisi komentar, dan ' . htmlentities($name) . ' belum terdaftar.';
$lang_comment_needname = 'Anda harus mengisi nama anda..<br /><a href="javascript:history.go(-1)">kembali kehalaman sebelumnya</a>';
$lang_comment_invalidmail = 'Alamat e-mail yang anda isi tidak valid.<br /><a href="javascript:history.go(-1)">kembali kehalaman sebelumnya</a>';
$lang_comment_needvalidmail = 'Anda belum mengisi email atau URL yang valid.<br /><a href="javascript:history.go(-1)">kembali kehalaman sebelumnya</a>';
$lang_comment_notblank = 'Komentar tidak boleh kosong.<br /><a href="javascript:history.go(-1)">kembali kehalaman sebelumnya</a>';
$lang_comment_notaccepted = 'Maaf, komentar sudah tidak diterima lagi.';
$lang_article_notfound = 'Artikel dengan id: <strong>' . htmlentities($id) . '</strong> tidak ditemukan';
$lang_article_linktext = 'Klik disini untuk mengisi komentar';
$lang_archive_notopen = 'Folder ' . htmlentities($cutepath) . '/data/archives tidak dapat di buka';

## search.php
$lang_search_header = "Pencarian...";
$lang_search_news = "Artikel";
$lang_search_title = "Judul";
$lang_search_author = "Ditulis oleh";
$lang_search_from = "Pencarian dari";
$lang_search_to = "Pencarian sampai";
$lang_search_archives = "Cari di dalam berkas";
$lang_search_advanced = "Tingkat lanjut..";
$lang_search_cnoarch = "Tidak dapat membuka " . htmlentities($cutepath) . "/data/archives";
$lang_search_found = "<strong>Ditemukan artikel yang sesuai dengan pencarian anda!</strong><br />";
$lang_search_founddate = " ";
$lang_search_notfound = "<strong>Tidak</strong> ditemukan artikel yang sesuai dengan pencarian anda.";
$lang_search_button = "Cari!";

## Date
$lang_and = "dan";
$lang_dates = array(
	year => "tahun",
	month => "bulan",
	week => "minggu",
	day => "hari",
	hour => "jam",
	minute => "menit",
	second => "detik",
	
	plural => 
		array(
			year => "tahun",
			month => "bulan",
			week => "minggu",
			day => "hari",
			hour => "jam",
			minute => "menit",
			second => "detik",
			),
);

$lang_days = array(
	monday => "senin",
	tuesday => "selasa",
	wednesday => "rabu",
	thursday => "kamis",
	friday => "jumat",
	saturday => "sabtu",
	sunday => "minggu",
);

$lang_months = array(
	january => "januari",
	february => "pebruari",
	march => "maret",
	april => "april",
	may => "mei",
	june => "juni",
	july => "juli",
	august => "agustus",
	september => "september",
	october => "oktober",
	november => "nopember",
	december => "desember",
	);
?>
