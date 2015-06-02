<?php
// part of orsee. see orsee.org
include ('common.php');
$pagetitle=$settings['default_area'];
if (isset($title)) $pagetitle=$pagetitle.': '.$title;


html__header();
include ("../style/".$settings['style']."/html_header.php");

echo "<center>";

show_message();

echo "</center>";

?>
