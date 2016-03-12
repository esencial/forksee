<?php
// part of orsee. see orsee.org
ob_start();

$menu__area="experiments_old";
$title="old experiments";
include("header.php");

	if (isset($_REQUEST['class']) && $_REQUEST['class']) $tclass=$_REQUEST['class']; else $tclass="";
		if (($expadmindata['admin_type']=='installer') or ($expadmindata['admin_type']=='admin')){ 
        	experiment__current_experiment_summary("","y",true);
		}else{
			experiment__current_experiment_summary($expadmindata['adminname'],"y",true);
		}
include("footer.php");

?>
