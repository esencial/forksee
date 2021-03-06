<?php
// part of orsee. see orsee.org
ob_start();

	if (isset($_REQUEST['item'])) $item=$_REQUEST['item']; else $item="";

	if (isset($_REQUEST['id'])) $id=$_REQUEST['id']; else $id="";

	if (!$id || !$item) redirect ("admin/");

$menu__area="options";
$title="delete ".str_replace("_"," ",$item);
include ("header.php");

	if (isset($_REQUEST['betternot']) && $_REQUEST['betternot'])
                redirect ('admin/lang_item_edit.php?item='.$item.'&id='.$id);

        if (isset($_REQUEST['reallydelete']) && $_REQUEST['reallydelete']) $reallydelete=true;
                        else $reallydelete=false;

	$titem=orsee_db_load_array("lang",$id,"lang_id");

	$done=false;
	$formfields=participantform__load(); $allow_cat=$item;
	foreach($formfields as $f) {
		if ($f['type']=='select_lang' && $item==$f['mysql_column_name']) {
			$done=true;
			$header=isset($lang[$f['name_lang']])?$lang[$f['name_lang']]:$f['name_lang'];
			$headervar=$lang['lang'];
			$reset_part_field=$f['mysql_column_name'];
			$deletion_message=$lang['symbol_deleted'];
			$allow_cat='pform_lang_field';
            break;
		}
    }
    $allow=check_allow($allow_cat.'_delete','lang_item_edit.php?id='.$id.'&item='.$item);
	
        switch($item) {
						case 'experimentclass':
							$header=""; //$lang['delete_experiment_class']; 
							$headervar=$lang['lang'];
							$reset_part_field="";
							$deletion_message=""; //$lang['experiment_class_deleted'];
						break;
                        case 'public_content':
                            $header=$lang['delete_public_content'];
                            $headervar="content_name";
							$reset_part_field="";
							$deletion_message=$lang['public_content_deleted'];
                            break;
                        case 'help':
                                                $header=$lang['delete_help'];
                                                $headervar="content_name";
                                                $reset_part_field="";
                                                $deletion_message=$lang['help_deleted'];
                                                break;
                        case 'mail':
                                                $header=$lang['delete_default_mail'];
                                                $headervar="content_name";
                                                $reset_part_field="";
                                                $deletion_message=$lang['default_mail_deleted'];
                                                break;
                        case 'default_text':
                                                $header=$lang['delete_default_text'];
                                                $headervar="content_name";
                                                $reset_part_field="";
                                                $deletion_message=$lang['default_text_deleted'];
                                                break;
		        		case 'laboratory':
                                                $header=$lang['delete_laboratory'];
                                                $headervar="content_name";
                                                $reset_part_field="";
                                                $deletion_message=$lang['laboratory_deleted'];
                                                break;
                }

	$cid=$titem['content_name'];

	echo '<center><BR>
                        <h4>'.$header.' '.$titem[$headervar].'</h4>';


        if ($reallydelete) {

                $query="DELETE FROM ".table('lang')."
                        WHERE lang_id='".$id."'";
                $result=mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));

		if ($reset_part_field) {
                	$query="UPDATE ".table('participants')." 
                 		SET ".$reset_part_field."='0'
                 		WHERE ".$reset_part_field."='".$cid."'";
                	$result=mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));

                        $query="UPDATE ".table('participants_temp')."
                                SET ".$reset_part_field."='0'
                                WHERE ".$reset_part_field."='".$cid."'";
                        $result=mysqli_query($GLOBALS['mysqli'],$query) or die("Database error: " . mysqli_error($GLOBALS['mysqli']));

			}

                message ($deletion_message);
		log__admin($item."_delete","lang_id:".$titem['content_type'].','.$titem['content_name']);
                redirect ('admin/lang_item_main.php?item='.$item);
                }

        // form

        echo '  <CENTER>
                <FORM action="lang_item_delete.php">
                <INPUT type=hidden name="id" value="'.$id.'">
		<INPUT type=hidden name="item" value="'.$item.'">

                <TABLE>
                        <TR>
                                <TD colspan=2>
                                        '.$lang['do_you_really_want_to_delete'].'
                                        <BR><BR>';
                                        dump_array($titem); echo '
                                </TD>
                        </TR>
                        <TR>
                                <TD align=left>
                                        <INPUT type=submit name=reallydelete value="'.$lang['yes_delete'].'">
                                </TD>
                                <TD align=right>
                                        <INPUT type=submit name=betternot value="'.$lang['no_sorry'].'">
                                </TD>
                        </TR>
                </TABLE>

                </FORM>
                </center>';

include ("footer.php");

?>
