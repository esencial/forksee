<?php
// part of orsee. see orsee.org
ob_start();
ini_set( 'display_errors', 1 );
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

include ("footer.php");

function formulario_contacto() {
    global $lang;
    $this_lang=$lang['lang'];
    echo '<form action="post.php" method="post">';
    echo '<table><tr><td>'.$lang['name'].'</td><td>';
    echo '<input type="text" name="fname"></td></tr><tr><td>';
    echo $lang['email'];
    echo '</td><td><input type="text" name="email"></td></tr><tr><td>';
    echo $lang['email_subject'];
    echo '</td><td><input type="text" name="subject"></td></tr><tr><td>';
    echo $lang['body_of_message'];
    echo '</td><td><textarea rows="4" cols="50" type="text" name="message"></textarea></td></tr><tr><td>';
    echo '<p class="url">Write your url: <input type="text" name="url" /></p>
</td></tr><tr><td>'; 
   // echo $_SESSION['captcha']['image_src'];
    echo '</td><td><input type="submit" value="Submit"></td></tr></table>';
    echo '</form>';   
    
}

?>
