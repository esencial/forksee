<?php
include("header.php");

if(is_null($_SESSION['login_user']))
{
    header("location: participant_login.php");
}

if(isset($_POST['submit'])){
    if(!empty($_POST['check_list'])) {
        $totalSelected =0;
       
        //Comprobamos que el total seleccionado no supera el total disponible de creditos
        foreach($_POST['check_list'] as $checked) {
             $query = "SELECT * FROM ".table('subjects')." WHERE subject_id='".$checked."'";
             $result = orsee_query($query,'S');
             foreach($result as $row) {
                 $totalSelected = $totalSelected + $row['credits'];
             }
        }
        
        if($totalSelected<=$_POST['totalCredits']){
        
            //Recogemos valores necesarios para el insert en la tabla subjects_participant
            $query = "SELECT * FROM ".table('participants')." WHERE identification_number='".$_SESSION['login_user']."'";
            $result = orsee_query($query,'S');
            foreach($result as $row) {
                $participant_name=$row['fname'];
            }

            // Recorremos el conjunto de checkbox y averiguamos cuales ha marcado
            foreach($_POST['check_list'] as $checked) {

                $query1 = "SELECT * FROM ".table('subjects')." WHERE subject_id='".$checked."'";    //Recogemos el el nombre y creditos de la/s asignaturas seleccionadas
                $result1 = orsee_query($query1,'S');
                foreach($result1 as $row1) {
                    $subject_name=$row1['subject_desc'];
                    $subject_credits = $row1['credits'];
                }


                $query2 = "INSERT INTO ".table('subjects_participants')." (participant_id, participant_name, subject_id, subject_desc, credits_spent) VALUES ('".$_SESSION['login_user']."','".$participant_name."','".$checked."','".$subject_name."','".$subject_credits."')";  
                $result2=orsee_query($query2);

            }
        }
        else {
            echo "<b>You don't have enough credits</b></br></br>";
        }
    }
    else{
        echo "<b>Please select at least one subject</b></br>";
    }
}

$totalCredits=0;
$query = "SELECT * FROM ".table('participate_at')." WHERE participant_id='".$_SESSION['login_user']."' AND participated='y'";  
$result=orsee_query($query,'S');
foreach($result as $row)                  
{
    $query1 = "SELECT * FROM ".table('experiments')." WHERE experiment_id='".$row['experiment_id']."'";
    $result1=orsee_query($query1,'S');
    foreach($result1 as $row1)                  //Conseguimos el total de creditos de que dispone
    {
        $totalCredits=$totalCredits + $row1['experiment_credits'];
    }
}    

$query1 = "SELECT * FROM ".table('subjects_participants')." WHERE participant_id='".$_SESSION['login_user']."'";
$result1=orsee_query($query1,'S');
foreach($result1 as $row1) 
{
    $totalCredits=$totalCredits - $row1['credits_spent'];   //Restamos del total aquellas que ya hubiese canjeado
}


echo "</br><div  class='col-lg-4 col-md-4 col-sm-4 col-xs-4'><p style='font-size: 150%'>Number of credits: ".$totalCredits."</p></div></br></br>";

$query = "SELECT * FROM ".table('subjects');  
$result=orsee_query($query,'S');
echo '<form method="POST">';
echo "<div  class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>";

foreach($result as $row)                  
{
    $subject_spent=false;
    $query1 = "SELECT * FROM ".table('subjects_participants')." WHERE participant_id='".$_SESSION['login_user']."'"; 
    $result1=orsee_query($query1,'S');
    foreach($result1 as $row1)
    {
        if($row['subject_id']==$row1['subject_id'])     //Si encuentra una asignatura con su mismo id implicaría que ya ha canjeado dicha asignatura...
        {
            $subject_spent=true;            
        }
    }
    if($subject_spent==false)   // ...sino mostraremos dicha asignatura para que la muestre en un checkbox
    {
        echo '<input type="checkbox" name="check_list[]" value='.$row['subject_id'].'>'.$row['subject_desc'].' - '.$row['credits'].' Credits</input></br>';
    }
        
}
echo "</div></br></br></br></br>";
echo '<input type="hidden" name="totalCredits" value="'.$totalCredits.'">';
echo '<div  class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div><div  class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><input type="submit" name="submit" value="Assign Credits"></div>';
echo '</form>';

?>
<?php
include("footer.php");
?>
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

