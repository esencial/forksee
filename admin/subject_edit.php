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
            if(isset($_GET['id']) && isset($_GET['desc']))
                {
                    $id=$_GET['id'];
                    $former=$_GET['desc'];
                    $new_desc=$_POST['new'];
                    if(isset($_POST['submit']))
                        {                            
                            $query="UPDATE or_subjects SET subject_desc='".$new_desc."' WHERE subject_id='".$id."'";
                            $updating=mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));
                            if($updating)
                                {
                                    header('location:subject_list.php');
                                }
                        }
                }
        ?>
        
    <form method="post" action="">
        Asignatura:
        <input type="text" name="new" value="<?php echo $former ?>" />
        <br /><br /><br />
        <input type="submit" name="submit" value="Guardar" />
    </form>
        
    </body>
</html>
