<?php
// part of orsee. see orsee.org
ob_start();

	if (isset($_REQUEST['item'])) $item=$_REQUEST['item']; else redirect ("admin/");

	if (isset($_REQUEST['id'])) $id=$_REQUEST['id']; else $id="";

$menu__area="options";
$title="edit ".str_replace("_"," ",$item);
include ("header.php");

	$done=false;
	$formfields=participantform__load(); $allow_cat=$item;
	foreach($formfields as $f) {
		if ($f['type']=='select_lang' && $item==$f['mysql_column_name']) {
			$done=true;
			$header=isset($lang[$f['name_lang']])?$lang[$f['name_lang']]:$f['name_lang'];
            $new_id='time';
			$inputform='line';
			$check_allow_content_shortcut=false;
			$allow_cat='pform_lang_field';
		}
    }
    
	if (!$id) $allow=check_allow($allow_cat.'_edit','lang_item_main.php?item='.$item);
	else $allow=check_allow($allow_cat.'_edit','options_main.php');
	
    if (!$done) {

		switch($item) {
						case 'experimentclass':
                            if ($id) $header=$lang['edit_experiment_class']; 
							else $header=$lang['add_experiment_class'];
                            $new_id='time';
							$check_allow_content_shortcut=false;
                            $inputform='line';
                            break;
                        case 'public_content':
                                                if ($id) $header=$lang['edit_public_content']; else $header=$lang['add_public_content'];
                                                $new_id='content_shortcut';
						$inputform='area';
						$check_allow_content_shortcut=true;
                                                break;
                        case 'help':
                                                if ($id) $header=$lang['edit_help']; else $header=$lang['add_help'];
                                                $new_id='content_shortcut';
						$inputform='area';
						$check_allow_content_shortcut=true;
                                                break;
                        case 'mail':
                                                if ($id) $header=$lang['edit_default_mail']; else $header=$lang['add_default_mail'];
                                                $new_id='content_shortcut';
						$inputform='area';
						$check_allow_content_shortcut=true;
                                                break;
                        case 'default_text':
                                                if ($id) $header=$lang['edit_default_text']; else $header=$lang['add_default_text'];
                                                $new_id='content_shortcut';
                                                $inputform='area';
						$check_allow_content_shortcut=true;
                                                break;
                        case 'laboratory':
                                                if ($id) $header=$lang['edit_laboratory']; else $header=$lang['create_new_laboratory'];
                                                $new_id='content_shortcut';
                                                $inputform='area';
						$check_allow_content_shortcut=false;
						$extranote_content_shortcut=$lang['lab_lists_are_ordered_by_this_name'];
						$extranote_lang_field=$lang['first_line_is_lab_name_rest_is_address'];
						break;
			}
		}

		if ($id) $button_title=$lang['change']; else $button_title=$lang['add'];

	echo '<center><BR>
			<h4>'.$header.'</h4><BR><BR>';

	// load languages
	$languages=get_languages();


	if (isset($_REQUEST['edit']) && $_REQUEST['edit']) {

		$continue=true;

 		if ($new_id=='content_shortcut' && !$_REQUEST['content_shortcut']) {
                        message($lang['you_have_to_give_content_name']);
                        $continue=false;
                        }

  		foreach ($languages as $language) {
  			if (!trim($_REQUEST[$language])) {
  				message ($lang['missing_language'].": ".$language);
  				$continue=false;
  			} else {
  				$_REQUEST[$language]=trim($_REQUEST[$language]);
  			}
		}

   		if ($continue) {
			$sitem=$_REQUEST;
            $sitem['content_type']=$item;

			if (!$id) $new=true; else $new=false;

			if ($new) { 
				if ($new_id=="time") $sitem['content_name']=time();
				}
			//$sitem['lang_id']=$id;
			if ($new_id=="content_shortcut") $sitem['content_name']=trim($_REQUEST['content_shortcut']); 

			if ($new) { $id=lang__insert_to_lang($sitem); $done=true; }
			   else $done=orsee_db_save_array($sitem,"lang",$id,"lang_id");

			if (!$new && $new_id=="time") $sitem['content_name']=trim($_REQUEST['content_shortcut']);
			
   			if ($done) {
				log__admin($item."_edit","lang_id:".$sitem['content_type'].','.$sitem['content_name']);
				message ($lang['changes_saved']);
				if ($new) redirect ('admin/lang_item_main.php?&item='.$item);
				else redirect ('admin/lang_item_edit.php?id='.$id.'&item='.$item);
				}
		   	else {
   				message ($lang['database_error']);
				redirect ('admin/lang_item_edit.php?id='.$id.'&item='.$item);
				}
			}
	   	   else {
			$titem=$_REQUEST;
			if ($new_id=="content_shortcut") $titem['content_name']=$_REQUEST['content_shortcut'];
			}
		}


	if ($id) { $titem=orsee_db_load_array("lang",$id,"lang_id"); }
	else { $titem=array('content_name'=>''); }

	show_message();

	// form
	echo '	<FORM action="lang_item_edit.php" METHOD=POST>
		<INPUT type=hidden name="id" value="'.$id.'">
		<INPUT type=hidden name="item" value="'.$item.'">

		<TABLE>
			<TR>
				<TD>';
			if ($new_id=='content_shortcut') {
				echo $lang['content_name'].':';

				if (!$check_allow_content_shortcut || check_allow($allow_cat.'_add')) {
					echo '<BR><FONT class="small">'.$lang['symbol_name_comment'].'</FONT>';
					if (isset($extranote_content_shortcut) && $extranote_content_shortcut)
						echo '<BR><FONT class="small">'.$extranote_content_shortcut.'</FONT>';
					}
				}
			   else echo $lang['id'];
		echo '		</TD>
				<TD>';
			if ($new_id=='content_shortcut') {
				if (!$check_allow_content_shortcut || check_allow($allow_cat.'_add')) {
					echo '<INPUT type=text name="content_shortcut" size=30 maxlength=50 value="'.
						$titem['content_name'].'">';
					} else {
					echo $titem['content_name'].
					'<INPUT type=hidden name="content_shortcut" value="'.$titem['content_name'].'">';
					}
				}
			elseif ($id) 
				echo $titem['content_name'].
					'<INPUT type=hidden name="content_shortcut" value="'.$titem['content_name'].'">'; 
			   else echo '???';
		echo '		</TD>
			</TR>';
        /////ESTE ES EL CÓDIGO QUE DIBUJA EL FORMULARIO/////
	foreach ($languages as $language) {
		if (!isset($titem[$language])) $titem[$language]="";
		echo '	<TR>
				<TD>
					'.$language.':';
				if (isset($extranote_lang_field) && $extranote_lang_field)
                                        echo '<BR><FONT class="small">'.$extranote_lang_field.'</FONT>';
				echo '
				</TD>
				<TD>';
			if ($inputform=='area') 
				echo '<textarea name="'.$language.'" cols=50 rows=20 wrap=virtual>'.
					stripslashes($titem[$language]).'</textarea>';
			   else echo '<INPUT name="'.$language,'" type="text" size=30 maxlength=100 value="'.
					stripslashes($titem[$language]).'">';
			echo '	</TD>
			</TR>';
		}

	echo '	</TABLE>
		<TABLE>
			<TR>
				<TD COLSPAN=2 align=center>
					<INPUT name=edit type=submit value="'.$button_title.'">
				</TD>
			</TR>
		</table>
		</FORM>
		<BR>';

	if ($id && check_allow($allow_cat.'_delete')) {
		echo '<BR><BR><FORM action="lang_item_delete.php">
			<INPUT type=hidden name="id" value="'.$id.'">
			<INPUT type=hidden name="item" value="'.$item.'">
			<INPUT type=submit name="submit" value="'.$lang['delete'].'">
			</FORM>';
		}
	echo '<BR><BR>
		<A href="lang_item_main.php?item='.$item.'">'.icon('back').' '.$lang['back'].'</A><BR><BR>
		</center>';

include ("footer.php");

?>
