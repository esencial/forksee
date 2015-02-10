<?php
// part of orsee. see orsee.org
ob_start();
$menu__area="contact";
include ("header.php");

echo '<BR><BR>
	<div class="">
	<h4>'; echo $lang['contact'];
	echo '</h4>
		<BR>';
	//echo content__get_content("contact");
        //llamamos a una función que nos dibuje el formulario
        formulario_contacto ();
	echo '</div>';

           
session_start();
include("simple-php-captcha.php");
$_SESSION['captcha'] = simple_php_captcha();

include ("footer.php");

function formulario_contacto() {
    global $lang;
    $this_lang=$lang['lang'];
    echo '<form action="#" method="get">';
    echo $lang['name'];
    echo '<input type="text" name="fname"><br>';
    echo $lang['email'];
    echo '<input type="text" name="email"><br>';
    echo $lang['email_subject'];
    echo '<input type="text" name="subject"><br>';
    echo $lang['body_of_message'];
    echo '<textarea rows="4" cols="50" type="text" name="message"></textarea><br>';
    echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA" /><br>'; 
    echo $_SESSION['captcha']['image_src'];
    echo '<input type="submit" value="Submit">';
    echo '</form>';   
    
}

?>
