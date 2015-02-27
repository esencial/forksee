<?php
// part of orsee. see orsee.org
ob_start();

include ("header.php");

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>        
        <script>
            function confirmDelete(delUrl, subjDesc) {
              if (confirm("Are you sure you want to delete "+subjDesc+"?")) {
               document.location = delUrl;
              }
            }
        </script>
    </head>
    <body>
        <?php
         $query="SELECT * FROM or_subjects";  
         $result=mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));
         while($query2=mysqli_fetch_assoc($result))
            {
                $id=$query2['subject_id'];
                $desc=$query2['subject_desc'];
                echo "<table width=200><tr><td width=20>".$id."</td>";
                echo "<td width=20>".$desc."</td>";
                echo "<td width=20><a href='subject_edit.php?id=".$id.
                        "&desc=".$desc."'>Edit</a></td>";                
                echo "<td width=20><a href='javascript:confirmDelete(\"subject_delete.php?id=".$id."\", \"".$desc."\")'>Delete</a></td><tr></table>"; 
            }
         echo "<br><a href='subject_add.php'>Add subject</a>";   
        ?>
        
        
    </body>
</html>
