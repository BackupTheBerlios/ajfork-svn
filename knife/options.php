<?php

$moduletitle = "All options";

$menus[1] = '

<ul style="margin-left: 15px;">
	<li>plugins</li>
	<li><a href="?panel=users">users</a></li>
	<li><a href="?panel=template">templates</a></li>
	<li><a href="?panel=options&amp;screen=categories">categories</a></li>
	<li><a href="?panel=options&amp;screen=setup"><span style="color: #f32988;">k</span>nife setup</a></li>
</ul>
';


#
# Knife setup
#

function makeField($type, $name, $id, $value, $label) {
	return "<input type=\"$type\" name=\"$name\" id=\"$id\" value=\"$value\" /> <label for=\"$id\">$label</label>";
}

if ($_GET[screen] == "setup") {

	$main_content = makeField("text", "something", "theid", "something", "Label");
	$main_content .= "
	
	
	";

}


#
#	Add / List categories
#

if ($_GET[screen] == "categories" && !$_POST[addcat]) {

	$statusmessage = "Categories";
	$dataclass = new SettingsStorage('settings');
	$currentcats = $dataclass->settings['categories'];
	
	$main_content = '
	<div id="manage_cats_main" style="float: left; width: 60%;">
	<table><thead><th>ID</th><th>Name</th><th>Default template</th><th>Actions</th></thead>';
	
	foreach ($currentcats as $catid => $catinfo) {
		$main_content .= "<tr><form method=\"get\"><input type=\"hidden\" name=\"panel\" value=\"options\" /><input type=\"hidden\" name=\"catid\" value=\"$catid\" /><td>$catid</td><td>$catinfo[name]</td><td>$catinfo[template]</td><td><input type=\"submit\" value=\"Edit\" /><input type=\"submit\" name=\"action\" class=\"delete\" value=\"Delete\" /></td></form></tr>";
		}
	$main_content .='
	</table>
	</div><div style="float: right;">
	<h2>Add category</h2>
	<form id="add_cat_form" class="cpform" method="post">
	<input type="hidden" name="	panel" value="options" />
	<p><label for="add_cat_name">Name</label><br /><input class="inshort" type="text" id="add_cat_name" name="addcat[name]" /> 
	<select id="add_cat_defaulttpl" name="addcat[template]">
		<option value="4">List</option>
		<option value="3">Templates</option>
		<option value="3">Here</option>
	</select> <label for="add_cat_defaulttpl">Default template</label></p>
	<p><input type="submit" value="Add category" /></p>
	</form>	
	</div>';
	
	}
	
if ($_POST[addcat]) {

#
#	Add a new category (Routine)
#

	$now = time();
	$dataclass = new SettingsStorage('settings');
	$currentcats = $dataclass->settings['categories'];
	
	# Remove unwanted stuff!
	$_POST[addcat][name] = sanitize_variables($_POST[addcat][name]);
	$_POST[addcat][template] = sanitize_variables($_POST[addcat][password]);
		
		$data = array(
		"name"	=> stripslashes($_POST[addcat][name]),
		"template" 	=> stripslashes($_POST[addcat][template]),
		);
	
	$dataclass->settings['categories'][] = $data;
	$dataclass->save();
	
	# Give the user a status message
	$statusmessage = "Category &quot;$data[name]&quot; added";
	}


?>