
		<tr #error_fname#>
			<td>lang[firstname]</td>
			<td>#fname#</td>
		</tr>
		<tr #error_lname#>
                        <td>lang[lastname]</td>
                        <td>#lname#</td>
                </tr>
		<tr #error_password#>
                        <td>lang[password]</td>
                        <td>#password#</td>
                </tr>
		<tr #error_identification_number#>
                        <td>lang[identification_number]</td>
                        <td>#identification_number#</td>
                </tr>
		<tr #error_email#>
                        <td>lang[e-mail-address]</td>
                        <td>#email#</td>
                </tr>
        { #multiple_participant_languages_exist# 
		<tr #error_language#>
                        <td>lang[language]</td>
                        <td>#language#</td>
                </tr> }

		{ #is_not_admin#
		<tr>
			<td colspan="2">lang[optional_fields_follow]</td>
		</tr> }

		<tr #error_phone_number#>
                        <td>lang[phone_number]
			{ #is_not_admin# <BR><FONT class="small">lang[phone_number_remark]</FONT> }
			</td>
                        <td>#phone_number#</td>
                </tr>

		<tr #error_gender#>
                        <td>lang[gender]</td>
                        <td>#gender#</td>
                </tr>

		<tr>
                        <td>lang[active_alerts]</td>
                        <td>#active_alerts#</td>
                </tr>

		<tr>
                        <td>lang[psychology_student]</td>
                        <td>#psychology_student#</td>
                </tr>

		<tr>
                        <td>lang[student_from_this_university]</td>
                        <td>#student_from_this_university#</td>
                </tr>

		<tr>
                        <td>lang[date_of_birth]</td>
                        <td>lang[day]#day_of_birth#lang[month]#month_of_birth#lang[year]#year_of_birth#</td>
                </tr>

		{ #is_subpool_type_b#
                <tr>
			<td></td>
                	<td>
                		<table width="100%" border="0">
                			<tr>
						<td #error_field_of_studies#>lang[studies]<br />#field_of_studies#</td>

        					<td align="center">&nbsp;lang[or]&nbsp;</td>

						<td #error_profession#>lang[profession]<br />#profession#</td>
					</tr>
					<tr>
						<td #error_begin_of_studies#>lang[begin_of_studies]<br />#begin_of_studies#</td>
						<td colspan="2"></td>
					</tr>
				</table>
			</td>
                </tr> }

		{ #is_subpool_type_s#
                <tr #error_field_of_studies#>
                        <td>lang[studies]</td>
                        <td>#field_of_studies#</td>
		</tr>

		<tr #error_begin_of_studies#>
			<td>lang[begin_of_studies]</td>
			<td>#begin_of_studies#</td>
                </tr> }

		{ #is_subpool_type_w#
                <tr #error_profession#>
                        <td>lang[profession]</td>
                        <td>#profession#</td>
                </tr> }

