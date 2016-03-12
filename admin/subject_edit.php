<?php
// part of orsee. see orsee.org
ob_start();

include ("header.php");
if(isset($_GET['id']) && isset($_GET['desc'])) $id=$_GET['id'];
if ($id) $allow=check_allow('subjects_edit','subject_main.php');
	else $allow=check_allow('subjects_add','subject_main.php');

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php //subject_desc, degree, year, credits
            if(isset($_GET['id']) && isset($_GET['desc']))
                {
				    $id=$_GET['id'];
                    $former=$_GET['desc'];
                    $new_desc=$_POST['subject'];
					$degree = $_POST['degree'];
					$credits = $_POST['credits'];
					$year = $_POST['year'];
					$email = $_POST['email'];
					 if(isset($_POST['submit']))
                     {                            
                         $query="UPDATE or_subjects SET year= '".$year."', degree= '".$degree."', credits='".$credits."', subject_desc='".$new_desc."', email ='".$email."' WHERE subject_id='".$id."'";
                         $updating=mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));
                         if($updating)
                             {
                                 header('location:subject_main.php');
                             }
                     }
					$query="SELECT * FROM or_subjects WHERE subject_id=".$_GET['id'];  

			        $result=mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));
					while($row = mysqli_fetch_assoc($result)) {
						$id = $row['subject_id'];
                    	$new_desc = $row['subject_desc'];
						$degree = $row['degree'];
						$credits = $row['credits'];
						$year = $row['year'];
       					$email = $_POST['email'];             	
                	}
				}
				
        ?>
        
    <form method="post" action="">
       	 <?php echo $lang['asignatura']; ?>
	<input type="text" name="subject" value="<?php echo $former ?>" />
        <br /><br />
        <?php echo $lang['grado']; ?>
		<input type="text" name="degree" value="<?php echo $degree ?>" />
        <br /><br />
        <?php echo $lang['curso']; ?>
		<input type="text" name="year" value="<?php echo $year ?>" />
        <br /><br />
        <?php echo $lang['creditos']; ?>
		<input type="text" onkeypress='validate(event)' name="credits" value="<?php echo $credits ?>" />
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

