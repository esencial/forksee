<?php
// part of orsee. see orsee.org
ob_start();

$title="login";

include("header.php");


	echo '<center>
		<BR><BR>';

	if (isset($_REQUEST['logout']) && $_REQUEST['logout']) message($lang['logout']);

	if (isset($_REQUEST['pw']) && $_REQUEST['pw']) {
		message($lang['logout']);
		message ($lang['password_changed_log_in_again']);
		}

	show_message();

	echo '	<H4>'.$lang['admin_login_page'].'</H4>
	<div id="login">
		';

	if (isset($_REQUEST['adminname']) && isset($_REQUEST['password'])) {
		$password=unix_crypt($_REQUEST['password']);
		$logged_in=admin__check_login($_REQUEST['adminname'],$password);
		if ($logged_in) {
			$expadmindata['admin_id']=$_SESSION['expadmindata']['admin_id'];
			log__admin("login");
		//	if ($_REQUEST['redirect']) redirect($_REQUEST['redirect']);
				//else 
				redirect("admin/experiment_my.php");
			}
		   else {
			message($lang['error_password_or_username']);
			redirect("admin/admin_login.php");
			}
		}

	check_options_exist();

	admin__login_form();

	echo '</div>';
    echo message($lang['pie_login_page']);
    echo '</center>';

include("footer.php");

?>
