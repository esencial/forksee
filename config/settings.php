<?php
// part of orsee. see orsee.org
error_reporting(E_ALL);

// Settings

// charset, either 'UTF-8' or 'ISO-8859-1'. Will determine
// how the HTML output encoding is declared
$settings__charset="UTF-8";

// Web server document root, e.g. /srv/www/htdocs
// no trailing slash!
$settings__root_to_server="/Usuarios/silvia/Documentos/ORSEE/forksee/forksee_local";


// Experiment system root relative to server root, e.g. /orsee
// begins always with "/" if in a subdirectory
// no trailing slash!
$settings__root_directory="/";

// url to web server document root (IP or domain name)
// without trailing slash and the http://!
$settings__server_url="forksee.local";

// Database configuration. Don't forget to create the database
$site__database_host="localhost";
//$site__database_port="3306"; // set only if not default 3306
$site__database_database="forksee_db";
$site__database_admin_username="root";
$site__database_admin_password="root";
$site__database_type="mysql";
$site__database_table_prefix="or_";

// If this is set to "y", the admin site is not reachable for nobody
// This is useful for some database procedures
$settings__stop_admin_site="n";


// to stop tracking set to 'y'
$settings__disable_orsee_tracking="n";

?>
