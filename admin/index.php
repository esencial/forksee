<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// part of orsee. see orsee.org
ob_start();

$menu__area="mainpage";
$title="Welcome";

include("header.php");

	echo '<BR><BR><center>
		';

	show_message();

	echo content__get_content("admin_mainpage");

	echo '</center><BR><BR>';

include("footer.php");

?>
