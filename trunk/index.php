<?PHP
/*
Aj-Fork based on Cutenews 1.3.1 by Georgi Avramov
Copyright (C) 2004  Øivind Overå Hoel

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

Full license at http://www.gnu.org/licenses/gpl.txt
*/

error_reporting (E_ALL ^ E_NOTICE);

require_once("./inc/functions.inc.php");
require_once("./inc/version.php");

//#################

$PHP_SELF					= "index.php";
$cutepath					= ".";
$config_path_image_upload	= "./data/upimages";

$config_use_cookies			= TRUE;  // Use Cookies When Checking Authorization
$config_use_sessions		= FALSE;  // Use Sessions When Checking Authorization
$config_check_referer		= FALSE; // Set to TRUE for more security
//#################


// Start plugin hack
include('./inc/plugins.php');
LoadActivePlugins();
// End plugin hack

$Timer = new microTimer;
$Timer->start();

// Check if CuteNews is not installed
$all_users_db = file("./data/users.db.php");
$check_users = $all_users_db;
$check_users[1] = trim($check_users[1]);
$check_users[2] = trim($check_users[2]);
if((!$check_users[2] or $check_users[2] == "") and (!$check_users[1] or $check_users[1] == "")){
	    require("./inc/install.mdu"); die();
}

require_once("./data/config.php");
if(isset($config_skin) and $config_skin != "" and file_exists("./skins/${config_skin}.skin.php")){
	require_once("./skins/${config_skin}.skin.php");
}else{
	require_once("./skins/default.skin.php");
}


if($config_use_sessions){
@session_start();
@header("Cache-control: private");
}

if($action == "logout")
{
    setcookie("md5_password","");
	setcookie("username","");
	setcookie("login_referer","");

    if($config_use_sessions){
    	@session_destroy();
	    @session_unset();
	    setcookie(session_name(),"");
	}
    msg("info", "Logout", "You are now logged out, <a href=\"$PHP_SELF\">login</a><br /><br />");
}


$is_loged_in = FALSE;
$cookie_logged = FALSE;
$session_logged = FALSE;
$temp_arr = explode("?", $HTTP_REFERER);
$HTTP_REFERER = $temp_arr[0];
if(substr($HTTP_REFERER, -1) == "/"){ $HTTP_REFERER.= "index.php"; }

// Check if The User is Identified

if($config_use_cookies == TRUE){
/* Login Authorization using COOKIES */

if(isset($username))
{
    if(isset($HTTP_COOKIE_VARS["md5_password"])){ $cmd5_password = $HTTP_COOKIE_VARS["md5_password"]; }
    elseif(isset($_COOKIE["md5_password"])){ $cmd5_password = $_COOKIE["md5_password"]; }
    else{ $cmd5_password = md5($password); }

    if(check_login($username, $cmd5_password))
    {	
        $cookie_logged = TRUE;
        setcookie("lastusername", $username, time()+1012324305);
        setcookie("username", $username);
        setcookie("ajip", $ip);
        setcookie("md5_password", $cmd5_password);

    }else{
    	$result = "<span class=\"warning\">Wrong username or password</span>";
        $cookie_logged = FALSE;
   }
}
/* END Login Authorization using COOKIES */
}

if($config_use_sessions == TRUE){
/* Login Authorization using SESSIONS */
	if(isset($HTTP_X_FORWARDED_FOR)){ $ip = $HTTP_X_FORWARDED_FOR; }
	elseif(isset($HTTP_CLIENT_IP))	{ $ip = $HTTP_CLIENT_IP; }
	if($ip == "")				    { $ip = $REMOTE_ADDR; }
	if($ip == "")					{ $ip = "not detected";}

if($action == "dologin")
{
	$md5_password = md5($password);
    if(check_login($username, $md5_password)){
		$session_logged = TRUE;

		@session_register('username');
		@session_register('md5_password');
		@session_register('ip');
		@session_register('login_referer');

		$_SESSION['username']		= "$username";
		$_SESSION['md5_password'] 	= "$md5_password";
		$_SESSION['ip']				= "$ip";
		$_SESSION['login_referer']	= "$HTTP_REFERER";

	}else{
		$result = "<span class=\"warning\">Wrong username or password</span>";
		$session_logged = FALSE;
	}
}elseif(isset($_SESSION['username'])){ // Check the if member is using valid username/password
    if(check_login($_SESSION['username'], $_SESSION['md5_password'])){
        if($_SESSION['ip'] != $ip){ $session_logged = FALSE; $result = "The IP in the session doesn not match with your IP"; }
        else{ $session_logged = TRUE; }
	}else{
		$result = "<span class=\"warning\">Wrong username or password</span>";
		$session_logged = FALSE;
	}
}

if(!$username){ $username = $_SESSION['username']; }
/* END Login Authorization using SESSIONS */
}

###########################

if($session_logged == TRUE or $cookie_logged == TRUE){
    if($action == 'dologin'){
	//-------------------------------------------
	// Modify the Last Login Date of the user
	//-------------------------------------------
	$old_users_db	= $all_users_db;
	$modified_users = fopen("./data/users.db.php", "w");
	foreach($old_users_db as $null => $old_users_db_line){
	   $old_users_db_arr = explode("|", $old_users_db_line);
	    if($member_db[0] != $old_users_db_arr[0]){
	    	fwrite($modified_users, "$old_users_db_line");
	    }else{
	        if(isset($HTTP_X_FORWARDED_FOR)){ $ip = $HTTP_X_FORWARDED_FOR; }
	elseif(isset($HTTP_CLIENT_IP))	{ $ip = $HTTP_CLIENT_IP; }
	if($ip == "")				    { $ip = $REMOTE_ADDR; }
	if($ip == "")					{ $ip = "not detected";}
	    	// fwrite($modified_users, "$old_users_db_arr[0]|$old_users_db_arr[1]|$old_users_db_arr[2]|$old_users_db_arr[3]|$old_users_db_arr[4]|$old_users_db_arr[5]|$old_users_db_arr[6]|$old_users_db_arr[7]|$old_users_db_arr[8]|".time()."||\n");
	    	fwrite($modified_users, "$old_users_db_arr[0]|$old_users_db_arr[1]|$old_users_db_arr[2]|$old_users_db_arr[3]|$old_users_db_arr[4]|$old_users_db_arr[5]|$old_users_db_arr[6]|$old_users_db_arr[7]|$old_users_db_arr[8]|".time()."|$ip|$old_users_db_arr[11]|$old_users_db_arr[12]|$old_users_db_arr[13]|||\n");
	    }
	}
	fclose($modified_users);
	}

	$is_loged_in = TRUE;
}

###########################

// If User is Not Logged In, Display The Login Page
if($is_loged_in == FALSE){
    if($config_use_sessions){
    	@session_destroy();
	    @session_unset();
		}
    setcookie("username","");
    setcookie("password","");
    setcookie("md5_password","");
    setcookie("login_referer","");
	
	$browser = $_SERVER['HTTP_USER_AGENT'];
	if (stristr($browser, "msie")) {
		$okbrowser = "no";
		if (stristr($browser, "opera")) {
			$okbrowser = "yes";
			}
		}

	if ($okbrowser == "no") {
		echoheader("user","Browser mismatch");
		echo "<div style=\"float: left;\">
		<p>You seem to be using Internet Explorer.<br />Currently this browser is too old to be used with modern 
		content like aj-fork. <br />To use this script you'll have to use a modern browser like <a href=\"http://www.mozilla.org\">mozilla firefox</a></p>
		</div>";
}



## Register code

elseif($action == "registerform"){
echoheader("user","New user registration");
echo<<<HTML
	<div style=\"float: left;\">	<form name="login" action="$PHP_SELF" method="post">
		<p><label for="regusername">Username:</label><br />		<input tabindex="1" type="text" name="regusername" id="regusername" size="20" /></p>

		<p><label for="regnickname">Nickname:</label><br />
		<input tabindex="2" type="text" name="regnickname" id="regnickname" size="20" /></p>

		<p><label for="regpassword">Password:</label><br />
		<input tabindex="3" type="text" name="regpassword" id="regpassword" size="20" /></p>

		<p><label for="regemail">Email:</label><br />
		<input tabindex="4" type="text" name="regemail" id="regemail" size="20" /></p>

		<p><input tabindex="5" accesskey="s" type="submit" value="Register" /></p>
		<p>$result<input type="hidden" name="action" value="doregister" /></p>
	</form>
	</div>
HTML;
	}
	elseif ($action == "doregister" && $config_users_selfregister == "allow") {
	if(!$regusername){ msg("error","Error", "Username can not be blank"); }
	if(!$regpassword){ msg("error","Error", "Password can not be blank"); }
	if(!$regemail)	 { msg("error","Error", "Email can not be blank"); }
	if(!preg_match("/^[\.A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $regemail))
	{ msg("error","Email issue", "This email doesn't validate as a real email address.."); }

	$levels = array(
		"a" => "1",
		"e" => "2",
		"j" => "3",
		"c" => "4",
		);

	$config_users_deflevel = $levels[$config_users_deflevel];

    $regusername	= sane_post_var($regusername);
    $regnickname	= sane_post_var($regnickname);
    $regemail		= sane_post_var($regemail);
    $regpassword	= sane_post_var($regpassword);

    $all_users = file("./data/users.db.php");
    foreach($all_users as $user_line)
    {
		$user_arr = explode("|", $user_line);
        if($user_arr[2] == $regusername){ msg("error", "Username Conflict", "This username is already taken"); }
    }

	$add_time = time()+($config_date_adjust*60);
	$regpassword = md5(md5($regpassword));

	$old_users_file = file("./data/users.db.php");
	$new_users_file = fopen("./data/users.db.php", "a");
		fwrite($new_users_file, "$add_time|$config_users_deflevel|$regusername|$regpassword|$regnickname|$regemail|0|0||||||||\n");
	fclose($new_users_file);

	msg("user", "Commenter Added", "You were successfully added to our database.<br />You may now <a href=\"index.php\">login</a>.");

	}


else { 
echoheader("user","Please Login");
echo "<div style=\"float: left;\">
     <form  id=\"login\" action=\"$PHP_SELF\" method=\"post\">
       	<p>
       	<label for=\"username\">Username</label><br />
       	<input tabindex=\"1\" size=\"28\" id=\"username\" type=\"text\" name=\"username\" value=\"$lastusername\" />
       	</p>
       	<p>
       	<label for=\"password\">Password</label><br />
       	<input tabindex=\"2\" size=\"28\" id=\"password\" type=\"password\" name=\"password\" />
       	</p>
       	<p>
		<input tabindex=\"3\" accesskey=\"s\" type=\"submit\" value=\"      Login...      \" />
		</p>
		<p>
		$result
		<input type=\"hidden\" name=\"action\" value=\"dologin\" />
		</p>
     </form>
	";
	if ($config_users_selfregister == "allow") {
		echo "<form id=\"newreg\" action=\"$PHP_SELF\" method=\"post\">
			<p>
				<input type=\"hidden\" name=\"action\" value=\"registerform\" />
				<input type=\"submit\" accesskey=\"n\" size=\"28\" tabindex=\"4\" value=\"New user\" />
			</p>
			</form>";
		}
	echo "
	</div>";
	}

echo "
<div id=\"main_boxcontent\">
	<div class=\"boxcontent_box\">
	<h3>About AJ-Fork</h3>
<p>
Aj-Fork is a branch of the CuteNews script by <a href=\"http://www.cutephp.com\">CutePHP / Flexer</a>. It focuses on adding
useful hacks, security updates, a plugin architecture and general code updates in the absence of periodical official CuteNews releases.</p>
<p>AJ-Fork is Licensed under the GNU GPL license (inherited from CuteNews - read the accompanying LICENSE file).</p>
<p>Copyright 2004 <a href=\"http://appelsinjuice.org/\">Øivind Hoel</a>
</p>
	</div>
</div>
";

   echofooter();
}
elseif($is_loged_in == TRUE)
{

//----------------------------------
// Check Referer
//----------------------------------
if($config_check_referer == TRUE){
	$self = $_SERVER["SCRIPT_NAME"];
    if($self == ""){ $self = $_SERVER["REDIRECT_URL"]; }
    if($self == ""){ $self = "index.php"; }

    if(!eregi("$self",$HTTP_REFERER) and $HTTP_REFERER != ""){
    	die("<h1>Access denied</h1><p>Try to <a href=\"?action=logout\">logout</a> and then login again. To turn off this security check, change \$config_check_referer in index.php to FALSE</p>");
	}
}
// ********************************************************************************
// Include System Module
// ********************************************************************************
                            //name of mod   //access
    $system_modules = array('addnews'  		=> 'user',
    			    'editnews'	 	=> 'user',
                            'main'	   	=> 'user',
                            'options'  		=> 'user',
                            'editusers'		=> 'admin',
                            'editcomments'	=> 'admin',
                            'tools'		=> 'admin',
                            'ipban'		=> 'admin',
                            'about'		=> 'user',
                            'preview'		=> 'user',
                            'categories'	=> 'admin',
                            'massactions'	=> 'user',
                            'help'		=> 'user',
                            'snr'		=> 'admin',
			    'xfields' 		=> 'any',
			    'credits'		=> 'any', 
			    'rss'			=> 'admin',
                            );

	run_actions('admin-page');
	$mod = htmlspecialchars(urldecode($mod)); 
    if($mod == ""){ require("./inc/main.mdu"); }
    elseif( $system_modules[$mod] )
    {
    	if($system_modules[$mod] == "user"){ require("./inc/". $mod . ".mdu"); }
        elseif($system_modules[$mod] == "admin" and $member_db[1] == 1){ require("./inc/". $mod . ".mdu"); }
        elseif($system_modules[$mod] == "admin" and $member_db[1] != 1){ msg("error", "Access denied", "Only admin can access this module"); exit;}
		elseif($system_modules[$mod] == "any") {require("./inc/{$mod}.mdu");}
        else{ die("Module access must be set to <strong>user</strong> or <strong>admin</strong>"); }
    }
    else{ die("$mod is NOT a valid module"); }
}

echo"<!-- execution time: ".$Timer->stop()." -->";
?>
