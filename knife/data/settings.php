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
        'password' => '03e6b9d67854d8c1265927e3322f77cdcd55e995',
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
      'john' => 
      array (
        'registered' => '1107804659',
        'nickname' => 'John|Will',
        'password' => '4749709942162cd47a8a71020b6446efe3cfad79',
        'email' => 'email@email.com',
        'url' => 'http://appelsinjuice.org',
        'profile' => 'sffafas',
        'level' => '4',
      ),
      'commenter' => 
      array (
        'registered' => '1107808829',
        'nickname' => 'commenterrr',
        'password' => '35a5aa9ebdfe1ad9afdcb323ffb3fb05341eb6b5',
        'email' => '',
        'url' => '',
        'profile' => '',
        'level' => '1',
      ),
      'jubbag' => 
      array (
        'registered' => '1107811415',
        'nickname' => 'Jared Judge',
        'password' => '4749709942162cd47a8a71020b6446efe3cfad79',
        'email' => '',
        'url' => '',
        'profile' => '',
        'level' => '4',
      ),
      'yoda' => 
      array (
        'registered' => '1107889400',
        'nickname' => 'The German',
        'password' => 'db11d626556186900a1cee5692406255e104a540',
        'email' => '',
        'url' => '',
        'profile' => '',
        'level' => '4',
      ),
    ),
    'categories' => 
    array (
      0 => 
      array (
        'name' => 'Blogg',
        'template' => '',
      ),
      1 => 
      array (
        'name' => 'PHP',
        'template' => '',
      ),
      2 => 
      array (
        'name' => 'Webdesign',
        'template' => '',
      ),
      3 => 
      array (
        'name' => 'About knife',
        'template' => '',
      ),
    ),
  ),
);
?>