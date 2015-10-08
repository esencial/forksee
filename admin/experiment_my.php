<?php

$experiment_GET = $_GET['exp'];

// part of orsee. see orsee.org
ob_start();

$menu__area="experiments_my";
$title="my experiments";
include("header.php");

if(!is_null($experiment_GET)){  //Si ha cambiado el select de experitmens.php, recogemos el nuevo valor y lo pasamos por referencia 
    
	experiment__current_experiment_summary($expadmindata['adminname'],"n",$experiment_GET);
}else{
        experiment__current_experiment_summary($expadmindata['adminname'],"n");
}
    
        experiment__current_experiment_summary($expadmindata['adminname'],"y");
 
include("footer.php");

?>
