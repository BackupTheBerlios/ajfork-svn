<?php

//session_destroy();
session_start();
if (!session_is_registered('imaConfig')) {
	session_register("imaConfig");
	// "settings"
		session_register("base_dir");                  	$base_dir = $_SERVER[DOCUMENT_ROOT] . "/";
		session_register("base_url");           		$base_url = "http://" . $_SERVER[HTTP_HOST] . "/";
		session_register("safe_mode");           		$safe_mode = "false";
		session_register("IMAGE_CLASS");        		$IMAGE_CLASS = "GD";
		session_register("IMAGE_TRANSFORM_LIB_PATH");   $IMAGE_TRANSFORM_LIB_PATH = "/usr/bin/";
		session_register("allow_new_dir");        		$allow_new_dir = "true";
		session_register("allow_upload");               $allow_upload = "true";
		                                    		
	// "optional"
		session_register("thumbnail_prefix");           $thumbnail_prefix = ".";
		session_register("thumbnail_dir");              $thumbnail_dir = ".thumbs";
		session_register("default_thumbnail");          $default_thumbnail = "img/default.gif";
		session_register("thumbnail_width");           	$thumbnail_width = "96";
		session_register("thumbnail_height");           $thumbnail_height = "96";
		session_register("validate_images");     		$validate_images = "true";
		session_register("tmp_prefix");      			$tmp_prefix = ".editor_";
}

switch ($_POST["id"]) {
	case "settings" :
		$base_dir = !isset($_POST["base_dir"]) ? NULL : $_POST["base_dir"];
		$base_url = !isset($_POST["base_url"]) ? NULL : $_POST["base_url"];
		$safe_mode = !isset($_POST["safe_mode"]) ? "false" : $_POST["safe_mode"];
		$IMAGE_CLASS = !isset($_POST["IMAGE_CLASS"]) ? "GD" : $_POST["IMAGE_CLASS"];
		$IMAGE_TRANSFORM_LIB_PATH = !isset($_POST["IMAGE_TRANSFORM_LIB_PATH"]) ? NULL  : $_POST["IMAGE_TRANSFORM_LIB_PATH"];
		$allow_new_dir = !isset($_POST["allow_new_dir"]) ? "false"  : $_POST["allow_new_dir"];
		$allow_upload = !isset($_POST["allow_upload"]) ? "false" : $_POST["allow_upload"];
		break;
	case "optional" :
		$thumbnail_prefix = !isset($_POST["thumbnail_prefix"]) ? NULL : $_POST["thumbnail_prefix"];
		$thumbnail_dir = !isset($_POST["thumbnail_dir"]) ? NULL : $_POST["thumbnail_dir"];
		$default_thumbnail = !isset($_POST["default_thumbnail"]) ? NULL : $_POST["default_thumbnail"];
		$thumbnail_width = !isset($_POST["thumbnail_width"]) ? NULL : $_POST["thumbnail_width"];
		$thumbnail_height = !isset($_POST["thumbnail_height"]) ? NULL : $_POST["thumbnail_height"];
		$validate_images = !isset($_POST["validate_images"]) ? "false" : $_POST["validate_images"];
		$tmp_prefix = !isset($_POST["tmp_prefix"]) ? NULL : $_POST["tmp_prefix"];
		break;
}



?>