<?php
// part of orsee. see orsee.org


function navigation($orientation="horizontal",$icons=true) {
	global $expadmindata, $lang, $navigation_disabled, $color;

   if (!(isset($navigation_disabled) && $navigation_disabled)) {
	if (isset($expadmindata['adminname'])) {
		$now=time();
		$current_user_data_box=$lang['admin_area'].''.
                	$lang['user'].': '.
                	$expadmindata['adminname'].''.
                	$lang['date'].': '.
                	time__format($expadmindata['language'],"",false,true,true,true,$now).''.
                	$lang['time'].': '.
                	time__format($expadmindata['language'],"",true,false,true,true,$now);
		$navfile=file ("../admin/navigation.php");
		}
	   else {
		$current_user_data_box="";
		$navfile=file ("../public/navigation.php");
		}

	foreach ($navfile as $entry) if (trim($entry) && substr(trim($entry),0,2)!="//") $menuitems[]=trim($entry);

	echo tab_menu($menuitems,$orientation,$current_user_data_box,$icons);
	}
}


function html__header($print=false) {
	global $pagetitle,$settings, $color, $settings__charset;

	//if ($print) $stylesheet="stylesheet_print.css"; else $stylesheet="stylesheet.css";

	if (isset($settings__charset) && $settings__charset=='ISO-8859-1') $charset='ISO-8859-1';
	else $charset='UTF-8';

echo '<!DOCTYPE html><html>
<HEAD>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="content-type" content="text/html; charset='.$charset.'">
<meta http-equiv="expires" content="0">
<TITLE>'.$pagetitle.'</TITLE>
    <link href="../style/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style/bootstrap/css/style.css" rel="stylesheet">
  
    <script type="text/javascript" src="../style/bootstrap/js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="../style/bootstrap/js/bootstrap.min.js"></script>
<!--
<link rel="stylesheet" type="text/css" href="../style/'.$settings['style'].'/'.$stylesheet.'">
-->
<script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>';

$url="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
$espubliccontent=strpos($url,'/public_content/');

if ($espubliccontent !== false){
echo '<script type="text/javascript">
tinymce.init({
    selector: "textarea"
 });
</script>'
;}

script__open_help();
if (thisdoc()=="admin_login.php") script__login_page();
if (thisdoc()=="faq.php") script__open_faq();

echo '
</HEAD>
<body class="container"><div ="row">';
/*if (isset($color['body_text'])) echo ' text="'.$color['body_text'].'"';
if (isset($color['body_link'])) echo ' link="'.$color['body_link'].'"';
if (isset($color['body_vlink'])) echo ' vlink="'.$color['body_vlink'].'"';
if (isset($color['body_alink'])) echo ' alink="'.$color['body_alink'].'"';
if (isset($color['body_bgcolor'])) echo ' bgcolor="'.$color['body_bgcolor'].'"';
echo ' TOPMARGIN=0 LEFTMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0';*/
//if (thisdoc()=="admin_login.php") echo ' onload="gotoUsername();"';
//echo '>
//';

}


function html__footer() {

echo '</div>
</BODY>
</HTML>';

}


function tab_menu($menu_items,$orientation="horizontal",$current_user_data_box="",$showicons=true) {
	// menu entry format:
 	// info[0]       1          2      3   4     5     6        7          8	  9
 	// entrytype|menu__area|lang_item|url|icon|target|addp?|showonlyifp?|hideifp?|options_condition

	global $settings__root_url, $color, $lang, $menu__area, $settings;


	if (isset($_REQUEST['p']) && !(thisdoc()=="participant_create.php")) {
                $addp="?p=".urlencode($_REQUEST['p']);
        	} 
	   else {
                $addp="";
        	}
        $url="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
        
        
        
        
        if (strpos($url,'/public/') !== false) {          

            echo '<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <div class="collapse navbar-collapse" id="bs-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI].'/public/index.php">maizjvzhlxcvjhxnpage</a></li> 
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Participant <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
        <li><a href="participant_create.php">register</a></li>
        <li><a href="participant_login.php">login</a></li>
        <li><a href="participant_edit.php">my data</a></li>
        <li><a href="participant_show.php">my registrations</a></li>
        </ul>
        </li>
        <li><a href="show_calendar.php">calendar</a></li>
        <li><a href="rules.php">rules</a></li>
        <li><a href="privacy.php">privacy_policy</a></li>
        <li><a href="faq.php">faqs</a></li>
        <li><a href="ie.php">internet_experiments</a></li>        
        <li><a href="impressum.php">impressum</a></li>
        <li><a href="contact.php">contact</a></li>        
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>';   
        }
        else
        {
            echo '<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <div class="collapse navbar-collapse" id="bs-navbar-collapse-2">
      <ul class="nav navbar-nav">
      <li><a href="/admin/">home</a></li>
      <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Experiments <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="experiment_main.php">Main</a></li>  
            <li><a href="experiment_my.php">My experiments</a></li>  
            <li><a href="experiment_old.php">Finished</a></li>  
            <li><a href="experiment_edit.php?addit=true">Create new experiment</a></li>
          </ul>
      </li>
      <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Participants <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="participants_main.php">Main</a></li>  
            <li><a href="participants_edit.php?addit=true">Create new participant</a></li>
          </ul>
      </li>    
      <li><a href="calendar_main.php">calendar</a></li> 
      <li><a href="download_main.php">download</a></li> 
      <li><a href="options_main.php">options</a></li> 
      <li><a href="statistics_main.php">stats</a></li> 
      <li><a href="admin_logout.php">logout</a></li> 
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
';
            
        }    
                }

function get_style_array() {
	global $settings__root_directory, $settings__root_to_server;

	$path=$settings__root_to_server.$settings__root_directory."/style";

   	$dir_arr = array () ;
   	$handle=opendir($path);
   	while ($file = readdir($handle)) {            
         	if ($file != "." && $file != ".." && is_dir($path."/".$file)) {                    
           		$dir_arr[] = $file ;        
       			}
   		}
   	return $dir_arr ;
}

?>
