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
    <body>hola
        <?php
         $query="SELECT * FROM or_subjects";
         $result=mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));
         while($query2=mysqli_fetch_assoc($result))
            {
                echo 'entra';
                echo "<tr><td>".$query2['subject_id']."</td>";
                echo "<td>".$query2['subject_description']."</td>";
                echo "<td><a href='edit.php?id=".$query2['id']."'>Edit</a></td>";
                echo "<td><a href='delete.php?id=".$query2['id']."'>x</a></td><tr>";
            }
        ?>he terminado
    </body>
</html>
