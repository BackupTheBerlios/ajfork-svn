<?php

include("config.php");
#include("lang_nor.php");
#file not in use

$adminpass = "2cjwag928e";


function c_option( $option ) {
	global $c;

	switch ( $option ) :
	case 'uri' :
		return $c->domain . $c->path;
		break;
	case 'unique' :
		return $c->unique;
		break;
	case 'page_topics' : 
		return $c->page_topics;
		break;
	case 'mod_rewrite' : 
		return $c->mod_rewrite;
		break;
	case 'path' : 
		return $c->path;
		break;
	case 'domain' :
		return $c->domain;
		break;
	case 'admin_email' : 
		return $c->admin_email;
		break;
	case 'edit_lock' :
		return $c->edit_lock;
		break;
	endswitch;
}

?>

<form id="login" method="post" action="">
<input type="text" name="username" />
<input type="text" name="password" />
<input type="submit" name="sendlogin" value="Logg inn" />
</form>

<?php

function c_login($gusername, $gpassword) {
	$unique = c_option('unique');
	$unique_password = $gpassword . $unique;

	$e_given = sha1(md5($unique_password));
	
	$users_arr = array(
		"eruin" 				=>	"04141f896069e740346920cdbbc468cc300498ca",
		"beskyddaren" 			=> 	"6e00c6b9c2154b762ef5f9188ad2dc57929acd55",
		);
	
	foreach ($users_arr as $user => $password) {
		if ($gusername == $user) {
			if ($e_given == $password) {
				$return = array(
					"user" => $user,
					"password" => $gpassword,
					"status" => "verified",
					);
				}
			}
		}
				
	if (!$return) {
		$return = array(
			"user" => $gusername, 
			"password" => $gpassword,
			"status" => "unverified",
			);
		}
	
	return $return;

}

if ($_POST[username] and $_POST[password]) {

	$check = c_login($_POST[username], $_POST[password]);
	if ($check[status] == "verified") {
		echo "you are logged in, $check[user]!";
		}
		
	else {
		echo "sorry, $check[user], but I couldn't verify you...</p>";
		}
	}
?>