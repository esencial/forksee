<?php
// part of orsee. see orsee.org
ob_start();
$menu__area="subjects_add";
$allow=check_allow('subjects_add','index.php');
include ("header.php");

?>


<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            $sbj_desc=$_POST['subject'];
            $sbj_degree=$_POST['degree'];
            $sbj_year=$_POST['year'];
            $sbj_credits=$_POST['credits'];
            $email = $_POST['email']; 
            if(isset($_POST['submit'])) {
                $query="INSERT INTO or_subjects (subject_desc, degree, year, credits, email)".
                        " VALUES ('".$sbj_desc."', '".$sbj_degree."', '".$sbj_year."', ".$sbj_credits.", '".$email."')";
                $inserting=mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));
                if($inserting)
                    {
                        header('location:subject_main.php');
                    }
            }
        ?>
        
        <form method="post" action="">
            <?php echo $lang['nueva_asignatura']; ?>
            <input type="text" name="subject" value="" />
            <br /><br />
            <?php echo $lang['grado']; ?>
            <input type="text" name="degree" value="" />
            <br /><br />
            <?php echo $lang['curso']; ?>
            <input type="text" name="year" value="" />
            <br /><br />
            <?php echo $lang['creditos']; ?>
            <input type="text" onkeypress='validate(event)' name="credits" value="" />
            <br /><br />
			<?php echo $lang['correo_electronico']; ?>
	        <input type="text" name="email" value="<?php echo $email ?>" />
	        <br /><br /><br />
            <button type="submit" style='color: #fff ;
		    background-color: #038516;
		    border-color: #2e6da4;
		    display: inline-block !important;
		    padding: 6px 12px !important;
		    margin-bottom: 0;
		    margin-right:10px;
		    font-size: 18px;
		    font-weight: 400;
		    line-height: 1.42857143;
		    text-align: center;
		    white-space: nowrap;
		    vertical-align: middle;
		    -ms-touch-action: manipulation;
		    touch-action: manipulation;
		    cursor: pointer; width:250px;
		    -webkit-user-select: none;
		    -moz-user-select: none;
		    -ms-user-select: none;
		    user-select: none;height:60px;
		    background-image: none; color:white;
		    border: 1px solid transparent;
		    border-radius: 4px;' name="submit">Guardar</button>
			<button type="reset" style='color: #fff ;
		    background-color: #038516;
		    border-color: #2e6da4;
		    display: inline-block !important;
		    padding: 6px 12px !important;
		    margin-bottom: 0;height:60px;
		    font-size: 18px;width:250px;
		    font-weight: 400;
		    line-height: 1.42857143;
		    text-align: center;
		    white-space: nowrap;
		    vertical-align: middle;
		    -ms-touch-action: manipulation;
		    touch-action: manipulation;
		    cursor: pointer;
		    -webkit-user-select: none;
		    -moz-user-select: none;
		    -ms-user-select: none;
		    user-select: none;color:white;
		    background-image: none;
		    border: 1px solid transparent;
		    border-radius: 4px;' name="cancel" onclick="window.history.back();">Cancelar</button>
        </form>
    </body>
</html>

<script>
function validate(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
</script>
