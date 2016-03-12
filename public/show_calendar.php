<?php
// part of orsee. see orsee.org
ob_start();

//error_reporting(E_ALL);
//ini_set('display_errors', 1);



include_once ("header.php");
include_once ('session.php');
include_once ('./assets/functions.php');
$menu__area="calendar";

//include ("header.php");

        
	if (!isset($_REQUEST['time'])) $_REQUEST['time']=time();

	echo '
		<center>
		<BR><BR>
		<H4>'.$lang['experiment_calendar'].'</h4>';
        
        softBan();
        
	if (!(isset($_REQUEST['year']) && $_REQUEST['year'])) {

		$lastmonth=date__skip_months(-1,$_REQUEST['time']);
		$nextmonth=date__skip_months(1,$_REQUEST['time']);

		echo '<BR><BR>
     			<A HREF="'.thisdoc().'?time='.$lastmonth.'">'.$lang['SOONER'].'</A>
     			<BR><BR>';

		calendar__month_table($_REQUEST['time'],1);

		echo '
			<BR><BR>
			<A HREF="'.thisdoc().'?time='.$nextmonth.'">'.$lang['LATER'].'</A>
			<BR><BR>';

		} else {

		$lastyear=date__skip_years(-1,$_REQUEST['time']);
		$nextyear=date__skip_years(1,$_REQUEST['time']);

		echo '
			<BR><BR>
			<A HREF="'.thisdoc().'?time='.$lastyear.'&year=true">'.$lang['SOONER'].'</A>
			<BR><BR>';

		calendar__show_year($_REQUEST['time']);

		echo '
			<BR><BR>
			<A HREF="'.thisdoc().'?time='.$nextyear.'&year=true">'.$lang['LATER'].'</A>
			<BR><BR>';
		}

	echo '
		</center>';

include ("footer.php");
          
         
?>

