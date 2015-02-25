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
         $query="SELECT * FROM or_subjects";  
         $result=mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));
         while($query2=mysqli_fetch_assoc($result))
            {
                echo "<table><tr><td>".$query2['subject_id']."</td>";
                echo "<td>".$query2['subject_desc']."</td>";
                echo "<td><a href='subject_edit.php?id=".$query2['subject_id'].
                        "&desc=".$query2['subject_desc']."'>Edit</a></td>";
                echo "<td><a href='subject_delete.php?id=".$query2['subject_id']."'>x</a></td><tr></table>";
            }
        ?>
    </body>
</html>
