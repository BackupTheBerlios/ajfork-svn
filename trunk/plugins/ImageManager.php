<?php
/*
Plugin Name: ImageManager
Plugin URI: http://www.soderlind.no/wp-plugins
Description: PHP ImageManager + Editor for Aj-Fork, accessible via the <strong>img quicktag</strong>. Prior to activating it, <a href="plugins/ImageManager/configure/" target="_blank">configure the ImageManager</a>. When you are ready to use it, read the <a href="http://www.zhuo.org/htmlarea/docs/index.html#manager" target="_blank">tutorial</a>.
Version: 1.0
Author: Per Soderlind
Author URI: http://www.soderlind.no
*/ 
/*
ImageManager integrates PHP ImageManager + Editor with WP
Copyright (c) 2004 Per Soderlind

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated
documentation files (the "Software"), to deal in the
Software without restriction, including without limitation
the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software,
and to permit persons to whom the Software is furnished to
do so, subject to the following conditions:

The above copyright notice and this permission notice shall
be included in all copies or substantial portions of the
Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY
KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR
OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

The plugin replaces the img quicktag, so .. to use it, click on the img quicktag.
*/


@add_action('admin_head', 'ImageManagerInit');
@add_action('admin_footer', 'ImageManagerCallBack');

function ImageManagerInit()
{
	if(strpos($_SERVER['REQUEST_URI'], 'index.php'))
	{
?>
<script type="text/javascript" src="plugins/ImageManager/assets/dialog.js"></script>
<script type="text/javascript" src="plugins/ImageManager/IMEStandalone.js"></script>
<script type="text/javascript">
//<![CDATA[
	//Create a new Imanager Manager, needs the directory where the manager is
	//and which language translation to use.
	var manager = new ImageManager('plugins/ImageManager','en');
			
	//Image Manager wrapper. Simply calls the ImageManager
	ImageSelector = 
	{
		//This is called when the user has selected a file
		//and clicked OK, see popManager in IMEStandalone to 
		//see the parameters returned.
		update : function(params)
		{
			var str = "";
			if (params.f_url != null) {
				str += '<img src="' + params.f_url + '"';
				str += (params.f_alt) ? ' alt="' + params.f_alt +'"' : '';
				str += (params.f_width) ? ' width="' + params.f_width +'"' : '';
				str += (params.f_height) ? ' height="' + params.f_height +'"' : '';
				str += (params.f_horiz) ? ' hspace="' + params.f_horiz +'"' : '';
				str += (params.f_vert) ? ' vspace="' + params.f_vert +'"' : '';
				str += (params.f_border) ? ' border="' + params.f_border +'"' : '';
				str += (params.f_class) ? ' class="' + params.f_class +'"' : '';
				str += ' />';
				edInsertContent(edCanvas, str);
			}
		},
		//open the Image Manager, updates the textfield
		//value when user has selected a file.
		select : function()
		{
			manager.popManager(this);	
		}
	};
//]]>
</script>
<?php
	}
}


function ImageManagerCallBack()
{
	if(strpos($_SERVER['REQUEST_URI'], 'index.php'))
	{
?>
<script type="text/javascript">
//<![CDATA[

function openImageManager() {
	ImageSelector.select();
}

var imgbutton = document.getElementById("ed_img");
imgbutton.onclick = openImageManager;
//]]>
</script>
<?php
	}
}

?>
