<?php
// part of orsee. see orsee.org

function orsee_session_open($aSavaPath, $aSessionName)
{
       global $aTime;

       orsee_session_gc( $aTime );
       return True;
}

function orsee_session_close()
{
       return True;
}

function orsee_session_read( $aKey )
{
       $query = "SELECT DataValue FROM ".table('http_sessions')." WHERE SessionID='$aKey'";
       $busca = mysqli_query($GLOBALS['mysqli'],$query) or die("Query:" . $query. "--- Database error: " . mysqli_error($GLOBALS['mysqli']));
       if(mysqli_num_rows($busca) == 1)
       {
             $r = mysqli_fetch_array($busca);
             return $r['DataValue'];
       } ELSE {
             $query = "INSERT INTO ".table('http_sessions')." (SessionID, LastUpdated, DataValue)
                       VALUES ('$aKey', NOW(), '')";
             mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));
             return "";
       }
}

function orsee_session_write( $aKey, $aVal )
{
	site__database_config();
       $aVal = addslashes( $aVal );
       $query = "UPDATE ".table('http_sessions')." SET DataValue = '$aVal', LastUpdated = NOW() WHERE SessionID = '$aKey'";
       mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));
       return True;
}

function orsee_session_destroy( $aKey )
{
	site__database_config();
       $query = "DELETE FROM ".table('http_sessions')." WHERE SessionID = '$aKey'";
       mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));
       return True;
}

function orsee_session_gc( $aMaxLifeTime )
{
	site__database_config();
	if (!isset($aMaxLifeTime) || (!$aMaxLifeTime)) $aMaxLifeTime=60*60;
       $query = "DELETE FROM ".table('http_sessions')." WHERE UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(LastUpdated) > $aMaxLifeTime";
       mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']). ", Query: ".$query);
       return True;
}

// deprecated !!!
function get_clean_expadmindata() {
        // get PHPSESSID from cookie
        $cookiestring=$_SERVER['HTTP_COOKIE'];
        preg_match("/^.*PHPSESSID=(.*)$/i",
        $cookiestring, $matches);
        $phpsid = $matches[1];

        // load data set from session table
        $session_table_data=orsee_query("SELECT * from ".table('http_sessions')." WHERE SessionID='".$phpsid."'");
        $session_data=$session_table_data['DataValue'];
	echo '<pre>';
	echo $session_data."<BR>";
        // proceed with data set to get out expadmindata array

	/*
        $expadstring=preg_match("/^.*expadmindata\|a:[0-9]+:\{([^\}]*)\}.*$/",$session_data,$matches);
        $datastr=$matches[1];*/


	var_dump($datastr);

        $dataarr=explode(";",$datastr);

        $i=0; $asize=count($dataarr);

        while ($i < $asize) {
                preg_match('/^[^"]*"([^"]*)"$/',$dataarr[$i],$matches);
                $varname=$matches[1];

                preg_match('/^[^"]*"([^"]*)"$/',$dataarr[$i+1],$matches);
                $varvalue=$matches[1];
                $expadmindata[$varname]=$varvalue;
                $i=$i+2;
                }
        // return it
	

	$tsession=decodesession($session_data);
	var_dump($tsession);

	//$expadmindata=$tsession['expadmindata'];
	echo '</pre>';
        return $expadmindata;
}

?>
