<?php
include("header.php");

if(is_null($_SESSION['login_user']))
{
    header("location: participant_login.php");
}

//Sentencia para impedir el acceso directo por URL a un selecy y textarea vacios
$experiment_GET = $_GET['exp'];

if(!is_null($experiment_GET))
{
    $query1 = "SELECT * FROM ".table('participate_at')." WHERE participant_id='".$_SESSION['login_user']."' AND experiment_id='".$experiment_GET."'"; 
    $result=orsee_query($query1);

    if(is_null($result)){   //si no resulta exitosa la consulta, quiere decir que el menda intentaba acceder por URL y le mandamos de vuelta al login

        header("location: participant_login.php");
    }
}   

?>

<script language="JavaScript" type="text/javascript">
        function getData(combobox){
                var value = combobox.options[combobox.selectedIndex].value;
                document.location.href = '?exp='+value;
        }
</script>



<?php

//ZONA POST

if ($_SERVER['REQUEST_METHOD']=='POST') //AL pulsar guardar...
{
    $experiment_GET = $_GET['exp']; //Primero comprobamos si cambio de select
    
    if(!is_null($experiment_GET))
    {
        $feedBack_POST=$_POST['feed'];

        $query1 = "UPDATE ".table('participate_at')." SET feedback='".$feedBack_POST."' WHERE participant_id='".$_SESSION['login_user']."' AND experiment_id='".$experiment_GET."'";  
        $result=orsee_query($query1);
        echo "</br></br><p align='center'>".$lang['changes_saved']."</p></br></br>";
    }
    else        //SI no cambio de select, está en el mismo que en el principio. Esto se ha montado asi ya que el elemnto <select> tiene el mismo nombre y no se puede distinguir si viene por GET o por POST para actualziarlos ya que parece que el superglogal $_request lo edita por igual
    {
        $expId_POST = $_POST['exp'];
        $feedBack_POST=$_POST['feed'];

        $query1 = "UPDATE ".table('participate_at')." SET feedback='".$feedBack_POST."' WHERE participant_id='".$_SESSION['login_user']."' AND experiment_id='".$expId_POST."'";  
        $result=orsee_query($query1);
       echo "</br></br><p align='center'>".$lang['changes_saved']."</p></br></br>";
    }  
}  
  
//END - ZONA POST

$experiment_GET = $_GET['exp'];

if(!is_null($experiment_GET))
{   
    $query1 = "SELECT * FROM ".table('participate_at')." WHERE participant_id='".$_SESSION['login_user']."'";  
    
    $result=orsee_query($query1,'S');
    
    
    
    $queryAux = "SELECT * FROM ".table('experiments')." WHERE experiment_id='".$experiment_GET."'";  
    $resultAux=orsee_query($queryAux,'S');
    
    foreach($resultAux as $rowAux)                  
    {    
        if($rowAux['experiment_id']==$experiment_GET)
        {
            $expName=$rowAux['experiment_name'];    //TEngo que hacer toda esta parafernalia por que no me recoge el valor de $resultAux['experiment_name'] y hay que ponerlo el primero en el <select>. BUscar solucion, es la peor ñapa de la historia
        }
    }
    echo '<form method="POST">';
    echo 'Select an experiment to see or add a feedback: <select name="exp" id="exp" onChange="getData(this)">';
    echo '<option>'.$expName.'</option>';  
    
    foreach($result as $row)
    {
        if($row['experiment_id']==$experiment_GET)
        {
            $feedBack = $row['feedback'];
        }
        
        $query2 = "SELECT * FROM ".table('experiments')." WHERE experiment_id='".$row['experiment_id']."'";
        $result2=orsee_query($query2,'S');
        
        foreach($result2 as $row2)
        {   
            if($row2["experiment_name"]!=$expName)
                echo'<option value='.$row2['experiment_id'].'>'.$row2["experiment_name"].'</option>';
        }
    }
    echo '</select>';
    
    echo '</br></br><div align="center"><textarea id="feed" name="feed" rows="10" cols="100">'.$feedBack.'</textarea></div></br></br>';
    
    echo '<input type="submit" value="Save Changes"></input>';
    
    echo '</form>';
}
else
{
        $query1 = "SELECT * FROM ".table('participate_at')." WHERE participant_id='".$_SESSION['login_user']."'";    
        $result=orsee_query($query1,'S');
        if(!is_null($result))
        {
            echo '<form method="POST">';
            echo 'Select an experiment to see or add a feedback: <select name="exp" id="exp" onChange="getData(this)">';
            //while(count($result)!=0)
            foreach($result as $row)
            {   
                if(!isset($firstFeedBack))
                {
                    if($row['feedback']==NULL){
                        $firstFeedBack="";          //Por si el primero fuera NULL y no se cumpliese el isset()
                    }
                    else{
                        $firstFeedBack = $row['feedback'];   //Es el primer registro de feedbacks y que coincide con el primero por defecto del <select>
                    }
                }

                $query2 = "SELECT * FROM ".table('experiments')." WHERE experiment_id='".$row['experiment_id']."'";
                $result2=orsee_query($query2,'S');
                foreach($result2 as $row2)
                {
                    echo'<option value='.$row2['experiment_id'].'>'.$row2["experiment_name"].'</option>';
                }


            }
            echo '</select>';

           echo '</br></br><div align="center"><textarea id="feed" name="feed" rows="10" cols="100">'.$firstFeedBack.'</textarea></div></br></br>';

           echo '<input type="submit" value="Save Changes"></input>';
           echo '</form>';
       }
       else
       {
           echo "You are not participanting in any experiment";
       }
}



?>

<?php
include("footer.php");
?>
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

