<?php
// part of orsee. see orsee.org
ob_start();

include ("header.php");

?>


<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            $new_desc=$_POST['new'];
            if(isset($_POST['submit'])) {
                $query="INSERT INTO or_subjects (subject_desc) VALUES ('".$new_desc."')";
                $inserting=mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));
                if($inserting)
                    {
                        header('location:subject_list.php');
                    }
            }
        ?>
        
        <form method="post" action="">
            Nueva asignatura:
            <input type="text" name="new" value="" />
            <br /><br /><br />
            <input type="submit" name="submit" value="Guardar" />
        </form>
    </body>
</html>
