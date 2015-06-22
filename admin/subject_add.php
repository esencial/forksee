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
            $sbj_desc=$_POST['subject'];
            $sbj_degree=$_POST['degree'];
            $sbj_year=$_POST['year'];
            $sbj_credits=$_POST['credits'];
            
            if(isset($_POST['submit'])) {
                $query="INSERT INTO or_subjects (subject_desc, degree, year, credits)".
                        " VALUES ('".$sbj_desc."', '".$sbj_degree."', '".$sbj_year."', ".$sbj_credits.")";
                $inserting=mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));
                if($inserting)
                    {
                        header('location:subject_main.php');
                    }
            }
        ?>
        
        <form method="post" action="">
            Nueva asignatura:
            <input type="text" name="subject" value="" />
            <br /><br />
            Grado:
            <input type="text" name="degree" value="" />
            <br /><br />
            Curso:
            <input type="text" name="year" value="" />
            <br /><br />
            Créditos:
            <input type="text" name="credits" value="" />
            <br /><br /><br />
            <input type="submit" name="submit" value="Guardar" />
        </form>
    </body>
</html>
