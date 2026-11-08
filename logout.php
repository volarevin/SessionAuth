<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

$_SESSION = array();

if (ini_get("session.use_cookies")) {
	$cookie_params = session_get_cookie_params();
	setcookie(
		session_name(),
		"",
		time() - 42000,
		$cookie_params["path"],
		$cookie_params["domain"],
		$cookie_params["secure"],
		$cookie_params["httponly"]
	);
}

session_destroy();

header("Location: index.php");
exit();
?>