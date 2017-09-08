<?
session_start();

/**
 * Delete cookies - the time must be in the past,
 * so just negate what you added when creating the
 * cookie.
 */
if (isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])) {
    setcookie("cookname", "", time() - 60 * 60 * 24 * 100, "/");
    setcookie("cookpass", "", time() - 60 * 60 * 24 * 100, "/");
}

/* Kill session variables */
unset($_SESSION['username']);
unset($_SESSION['password']);
$_SESSION = array();
// reset session array
session_destroy();
// destroy session.

echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php\">";
