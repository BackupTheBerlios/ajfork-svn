<?PHP
///////////////////// TEMPLATE Default /////////////////////
$template_active = <<<HTML
<div class="article">		
<h1>{title}</h1>
<h2>Published <em style="text-transform: capitalize;">{date}</em></h2>
<div class="article_text">
{short-story}
</div>
<span class="specials"><em>[com-link]Comments ({comments-num})[/com-link] | [full-link]Read more...[/full-link] - {category} - Viewed {views} times.</em>
</span>
</div>	
HTML;


$template_full = <<<HTML
<div class="article">

<script type="text/javascript">
var oldtitle = document.title;
document.title = oldtitle + ' | {title}';
</script>
	
<h1>{title}</h1>
<h2>Published <em style="text-transform: capitalize;">{date}</em></h2>
<div class="article_text">
{short-story}
</div>
<span class="specials"><em>[link]Permanent link[/link] - {category}</em>
</span>
</div>	

<div class="nextprev"><span class="prev">{prevlink}</span> <span class="next">{nextlink}</span></div>

[comheader]<h1><a id="kommentarene"></a>Comments <a href="#write" title="Comment on this article!">&gt;&gt;</a></h1>[/comheader]
HTML;


$template_comment = <<<HTML
<div class="comment" id="comment{comnum}">
<dl>
<dt><a href="#comment{comnum}" title="link to this comment">#<strong>{comnum}.</strong></a>
Written by <span class="{admin}com">{author}</span> (<small>{host}</small>) {date}:</dt>
<dd class="{admin}com"><div>{comment}</div></dd>
</dl>
</div>
HTML;


$template_form = <<<HTML
<div style="width: 100%;">
<h1><a id="write"></a>Spill your feelings!</h1>
<div style="float: left; border-right: 1px solid #cecece; margin-right: 15px; padding-right: 15px; margin-bottom: 15px;">
<p>
<label for="name">Name</label><br />
<input id="name" class="input"  type="text" size="28" name="name" tabindex="1" value="{savedname}" /></p>

<p>
<label for="mail">Em@il or URL</label><br />
<input id="mail" class="input" type="text" size="28" name="mail" tabindex="2" value="{savedmail}" />
</p>
</div>
<div>
<p>{remember} <label for="rememberme">Remember this?</label></p><p>Linebreaks are automatically added, and your name will be linked to your email or URI, depending on what you supply.</p><p>HTML allowed: {allowedtags}</p>
</div>
<div>
<p>
<label for="comments">Your comment</label>

<script type="text/javascript">
	<!--
  document.write('<small>[ <span style="cursor: pointer;" onclick="document.getElementById(\'comments\').rows += 5;" title="Click to enlarge the comments textarea">Bigger field field</span> | <span style="cursor: pointer;" onclick="document.getElementById(\'comments\').rows -= 5;" title="Click to decrease the comments textarea">Smaller field</span> ]</small>');
        //-->
        </script>


<br />
<textarea id="comments" class="input" cols="70" rows="4" name="comments" tabindex="3"></textarea>
</p>
<p>
<input class="input" type="submit" tabindex="4" name="submit" value="Add comment" accesskey="s" />
</p>
</div>
</div>
HTML;


$template_prev_next = <<<HTML
<span id="bloggsider">
[prev-link]More recent articles[/prev-link] ( {pages} ) [next-link]Older articles[/next-link]<br />
</span>
HTML;


$template_cprev_next = <<<HTML
<span id="bloggsider">
[prev-link]More recent comments[/prev-link] ( {pages} ) [next-link]Older comments[/next-link]<br />
</span>
HTML;


$template_dateheader = <<<HTML
<!-- DateHeader-->
<div class="dateheader"><h3 style="font-size: 16px;">{dateheader}</h3></div>
HTML;


?>
