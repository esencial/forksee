<?php
include("header.php");
global $lang;
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
           // $query = "SELECT * FROM ".table('participants')." WHERE identification_number='".$_SESSION['login_user']."'";
            //$result = orsee_query($query,'S');
            //foreach($result as $row) {
              //  $participant_name=$row['fname'];
            //}
			$participant_name=$_POST['name'];
            // Recorremos el conjunto de checkbox y averiguamos cuales ha marcado
            foreach($_POST['check_list'] as $checked) {

                $query1 = "SELECT * FROM ".table('subjects')." WHERE subject_id='".$checked."'";    //Recogemos el el nombre y creditos de la/s asignaturas seleccionadas
                $result1 = orsee_query($query1,'S');
                foreach($result1 as $row1) {
                    $subject_name=$row1['subject_desc'];
                    $subject_credits = $row1['credits'];
                }


                $query2 = "INSERT INTO ".table('subjects_participants')." (participant_id, participant_name, subject_id, subject_desc, credits_spent, sent) VALUES ('".$_SESSION['login_user']."','".$participant_name."','".$checked."','".$subject_name."','".$subject_credits."',0)";  
                $result2=orsee_query($query2);

            }
        }
        else {
            echo "<b>".$lang['no_enough_credits']."</b></br></br>";
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

$query1 = "SELECT * FROM ".table('subjects_participants')." WHERE sent = 0 and participant_id='".$_SESSION['login_user']."'";
$result1=orsee_query($query1,'S');
foreach($result1 as $row1) 
{
    $totalCredits=$totalCredits - $row1['credits_spent'];   //Restamos del total aquellas que ya hubiese canjeado
}


echo "</br><div  class='col-lg-12 col-md-12 col-sm-12 col-xs-12'><p style='font-size: 150%'>Créditos conseguidos: ".$totalCredits."</p></div></br></br>
<input type=hidden id='totalCr' value=".$totalCredits.">";

$query = "SELECT * FROM ".table('subjects');  
$result=orsee_query($query,'S');
echo '<form method="POST">';
echo "<div  class='col-lg-12 col-md-12 col-sm-12 col-xs-12'><table>";

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
        echo '<tr><td><input type="hidden" name="subject_id" value='.$row['subject_id'].'>'.$row['subject_desc'].'</td><td> '.$lang['total_possible_credits'].': '.$row['credits'].'</td><td>  Créditos a asignar: <input type="number" name="check_list[]" id="check_list[]" min="1" max="'.$row['credits'].'"></td></tr>';
    }
        
}
echo "</table></div>

<div class='clear'></div>";
echo '<input type="hidden" name="totalCredits" value="'.$totalCredits.'">';
echo $lang['student_name'].": <input type='text' class='texto-1' size=60 id='name' value='' required><br>";
echo '<div  class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><input type="submit" onclick="checkForm()" name="submit" value="'.$lang['assign_credits'].'"></div>';
echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'.$lang['credit_asignation_remark']."</div>";
echo '</form>';

?>
<?php
include("footer.php");
echo "
<script>
function checkForm(){
	var names = document.getElementsByName('check_list[]');
	var creditos = document.getElementById('totalCr');
	var total = 0;
	for(key=0; key < names.length; key++)  {
		var valor = parseInt(names[key].value);
		if (isNaN(valor)){
			valor=0;
			
		}
	    total = total + parseInt(valor);
		
	}
	if (parseInt(creditos.value)<parseInt(total)){
		alert ('ERROR: Tienes menos créditos de los que te has asignado.');
		return false;
	} else {
		return true;
	}
}
</script>
";

?>


