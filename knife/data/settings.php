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
<h1>[friendlylink]{title}[/friendlylink] {comments}</h1>
<strong>Posted by {author} (last edited by {lastedit}) in {category} ({date}) - [friendlylink]Friendly Link[/friendlylink] | [link]ID-Link[/link]</strong>
<div class="article_text">
{content}
<p>views: {views}<br />
latest comment by: {latestcomment}</p>
</div>',
        'view' => '<div class="article" style="margin-bottom: 40px;">
<h1>{title}</h1>
<strong>{date}</strong>
<div class="article_text">
{content}

{extended}
<p>views: {views}</p>
</div>',
        'comment' => '<div class="comment">
<div class="commentheader">
Comment posted {date} by <a href="{url}">{author}</a> (<a href="mailto:{mail}">@</a>)
</div>
<blockquote>{parentquote}</blockquote>
{comment}
</div>',
        'commentform' => '<h1>Add comment?</h1>
<input type="text" name="comment[parent]" /> Parent<br />
<input type="text" name="comment[name]" /> Name<br />
<input type="text" name="comment[email]" /> Email<br />
<input type="text" name="comment[url]" /> URL<br /><br />
Comment<br />
<textarea name="comment[content]" rows="7" cols="50"></textarea>
<input type="submit" name="comment[submit]" value="Add" />',
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
      'stealtheye' => 
      array (
        'registered' => '1107983191',
        'nickname' => 'StealthEye van Holland',
        'password' => 'dfe642fd06030c47d3c2ea15d28589bc9ce1fca0',
        'email' => '',
        'url' => '',
        'profile' => '',
        'level' => '4',
      ),
      'admin' => 
      array (
        'registered' => '1107983473',
        'nickname' => 'like.. an admin',
        'password' => '17dc22e4ab03b081598ea4b1d273cdc6327b942a',
        'email' => '',
        'url' => '',
        'profile' => '',
        'level' => '4',
      ),
    ),
    'categories' => 
    array (
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
      5 => 
      array (
        'name' => 'TempTesttwo',
        'template' => '1',
      ),
      6 => 
      array (
        'name' => 'PHP',
        'template' => '1',
      ),
      7 => 
      array (
        'name' => 'Life',
        'template' => '1',
      ),
    ),
  ),
);
?>