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
                            if($query)
                                {
                                    header('location:subject_list.php');
                                }
                        }
                }
        ?>
        
    <form method="post" action="">
        Nuevo nombre para la asignatura <?php echo $former ?>:
        <input type="text" name="new" value="" />
        <br /><br /><br />
        <input type="submit" name="submit" value="update" />
    </form>
        
    </body>
</html>
