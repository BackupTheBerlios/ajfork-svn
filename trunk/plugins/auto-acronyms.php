<?php

/*
Plugin Name:Auto Acronyms
Plugin URI:http://www.textbones.com/2004/6/25/AutoAcronyms
Description: Converts acronyms from posts and comments into HTML acronyms.
Version:1.0
Author:David Carrington
Author URI:http://www.brandedthoughts.co.uk
Required Framework: 1.0.0
*/

@add_filter('news-entry-content','auto_acronym');
@add_filter('news-comment-content','auto_acronym');
@add_filter('plugin-description','auto_acronym');

function auto_acronym($content,$hook) {
$acronyms = array(
'WYSIWYG' => 'What You See Is What You Get',
'RPC' => 'Remote Procedure Call',
'XHTML' => 'eXtensible HyperText Markup Language',
'LGPL' => 'GNU Lesser General Public License',
'MSDN' => 'Microsoft Developer Network',
'WCAG' => 'Web Content Accessibility Guidelines',
'SOAP' => 'Simple Object Access Protocol',
'OPML' => 'Outline Processor Markup Language',
'MSIE' => 'Microsoft Internet Explorer',
'FOAF' => 'Friend Of A Friend',
'GFDL' => 'GNU Free Documentation License',
'XSLT' => 'eXtensible Stylesheet Language Transformations',
'HTML' => 'HyperText Markup Language',
'HTTP' => 'HyperText Transfer Protocol',
'KSES' => 'KSES Strips Evil Scripts',
'FFDB' => 'Flat File DataBase',
'YaBB' => 'Yet Another Bulletin Board',
'I18N' => 'Internationalisation',
'i18n' => 'Internationalisation',
'URL' => 'Uniform Resource Locator',
'W3C' => 'World Wide Web Consortium',
'MSN' => 'Microsoft Network',
'P2P' => 'Peer To Peer',
'RSS' => 'Rich Site Summary',
'RDF' => 'Resource Description Framework',
'PHP' => 'PHP: Hypertext Preprocessor',
'IRC' => 'Internet Relay Chat',
'DOM' => 'Document Object Model',
'DTD' => 'Document Type Definition',
'FTP' => 'File Transfer Protocol',
'DVD' => 'Digital Versatile Disc',
'DNS' => 'Domain Name System',
'SQL' => 'Structured Query Language',
'CSS' => 'Cascading Style Sheet',
'CGI' => 'Common Gateway Interface',
'CMS' => 'Content Management System',
'FAQ' => 'Frequently Asked Questions',
'XML' => 'eXtensible Markup Language',
'XSL' => 'eXtensible Stylesheet Language',
'GPL' => 'GNU General Public License',
'CVS' => 'Concurrent Versioning System',
'SRK' => '((Strategic Air Command) Automated Command and Control System) Replacement Keyboard',
'IIS' => 'Internet Information Services',
'IE' => 'Internet Explorer',
'CD' => 'Compact Disc',
'GB' => 'Gigabyte',
'MB' => 'Megabyte',
'KB' => 'Kilobyte',
'ID' => 'Identification',
'DB' => 'DataBase',
'BB' => 'Bulletin Board',
'AJ-FORK' => 'link:http://ajfork.berlios.de',
'CUTENEWS' => 'link:http://cutephp.com',
'CUTEPHP' => 'link:http://cutephp.com',
'ERUIN' => 'link:http://appelsinjuice.org/',
);

		foreach ($acronyms as $acronym => $definition)
			if (stristr($definition, "link:")) {
				$definition = substr($definition, 5);
				$content = preg_replace("|([^./]\b)$acronym(\b[^:])|msU", '$1<a href="'.$definition.'">'.$acronym.'</a>$2', $content);				
				}
			else {
			$content = preg_replace("|([^./]\b)$acronym(\b[^:])|msU", '$1<acronym title="'.$definition.'">'.$acronym.'</acronym>$2', $content);
				}
		return $content;
}

?>
