<?php
$array = array (
  'settings' => 
  array (
    'templates' => 
    array (
      1 => 
      array (
        'name' => 'Default',
        'listing' => '<div class="article" style="margin-bottom: 40px;">
<h1>{title}</h1>
<strong>Posted by {author} in {category} ({date}) - [friendlylink]Friendly Link[/friendlylink] | [link]ID-Link[/link]</strong>
<div class="article_text">
{content}
</div>',
        'view' => '<div class="article" style="margin-bottom: 40px;">
<h1>{title}</h1>
<strong>{date}</strong>
<div class="article_text">
{content}

{extended}
</div>',
        'comment' => '',
        'commentform' => '',
      ),
      2 => 
      array (
        'name' => 'NotDefault',
        'listing' => '<div class="article" style="margin-bottom: 40px;">
<h1>{title}</h1>
<strong>Posted by {author} in {category} ({date}) - {friendlylink} | {link}</strong>
<div class="article_text">
{content}notdefault
</div>',
        'view' => '<div class="article" style="margin-bottom: 40px;">
<h1>{title}</h1>
<strong>{date}</strong>
<div class="article_text">
{content}

{extended}
</div>',
        'comment' => '',
        'commentform' => '',
      ),
    ),
    'users' => 
    array (
      'eruin' => 
      array (
        'registered' => '1107710351',
        'nickname' => 'Øivind Hoel',
        'password' => '04141f896069e740346920cdbbc468cc300498ca',
        'email' => 'oivind.hoel@appelsinjuice.org',
        'url' => 'http://appelsinjuice.org',
        'profile' => 'Min profil
Del to
Fire
Fem
Seks
Sju
Åtte',
        'level' => '4',
      ),
    ),
  ),
);
?>