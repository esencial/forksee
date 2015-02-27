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
            if(isset($_GET['id']))
                {
                    $id=$_GET['id'];
                    $query="DELETE FROM or_subjects WHERE subject_id='".$id."'";
                    $deleting=mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));
                    if($deleting)
                        {                        
                            header('location:subject_list.php');
                        }
                    echo $query;
                }
        ?>
    </body>
</html>
