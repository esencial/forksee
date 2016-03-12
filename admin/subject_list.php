<?php
// part of orsee. see orsee.org
ob_start();

include ("header.php");
$allow=check_allow('subjects_add','index.php');

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>        
        <script>
            function confirmDelete(delUrl, subjDesc) {
              if (confirm("Vas a borrar "+subjDesc+"¿Correcto?")) {
               document.location = delUrl;
              }
            }
        </script>
    </head>
    <body>
         <?php
	         $query="SELECT subject_id, subject_desc, degree, year, credits, email FROM or_subjects";  
	         $result=mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));
			echo "<table width=800><tr><th>".$lang['asignatura']."</th><th>".$lang['grado']."</th><th>".$lang['curso']."</th><th>".$lang['credito']."</th><th>".$lang['submit']."</th></tr>";
	         while($query2=mysqli_fetch_assoc($result))
	            {
	                $id=$query2['subject_id'];
	                $desc=$query2['subject_desc'];
	                $degree=$query2['degree'];
	                $year=$query2['year'];
	                $credits=$query2['credits'];
	                $email=$query2['email'];

	                echo "<tr><!--<td width=400>".$id."</td>-->";
	                echo "<td width=400>".$desc."</td>";
	                echo "<td width=50>".$degree."</td>";
	                echo "<td width=50>".$year."</td>";
	                echo "<td width=50>".$credits."</td>";
	                echo "<td width=100>".$email."</td>";

	                echo "<td width=50><a href='subject_edit.php?id=".$id.
	                        "&desc=".$desc."'>Editar</a></td>";            
	                echo "<td width=50><a href='javascript:confirmDelete(\"subject_delete.php?id=".$id."\", \"".$desc."\")'>".$lang['delete']."</a></td><tr>"; 
	            }

	         echo "</table><br><a href='subject_add.php'>".$lang['anadir_asignatura']."</a><br><a href='send_credits.php'>".$lang['enviar_creditos']."</a>";   
	        ?>
    </body>
</html>
