
		<!-- <tr #error_fname#>
			<td>lang[firstname]</td>
			<td>#fname#</td>
		</tr>
		<tr #error_lname#>
                        <td>lang[lastname]</td>
                        <td>#lname#</td>
                </tr> -->

		
		<tr #error_identification_name#>
                        <td>lang[identification_name]</td>
                        <td>#identification_name#</td>
                </tr>
		<tr #error_identification_number#>
			            <td>lang[identification_number]</td>
			            <td>#identification_number#</td>
			     </tr>		
				<tr #error_password#>
		                        <td>lang[password]</td>
		                        <td>#password#</td>
		                </tr>
							<tr>
					                        <td>lang[underage]</td>
					                        <td>#underage#</td>
					                </tr>

						<!--	<tr>
								<td class="toHide">lang[parent_firstname]</td>
								<td class="toHide">#parent_fname#</td>
							</tr>

							<tr>
					                        <td class="toHide">lang[parent_lastname]</td>
					                        <td class="toHide">#parent_lname#</td>
					                </tr>-->

							<tr>
					                        <td class="toHide">lang[parent_id]</td>
					                        <td class="toHide">#parent_id#</td>
					                </tr>
									<tr>
							                        <td class="toHide">lang[birth]</td>
							                        <td class="toHide">#birth#</td>
							                </tr>

									<tr>
							                        <td class="toHide">lang[diagnosis_suspected]</td>
							                        <td class="toHide">#diagnosis_suspected#</td>
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
                        <td class="only18">lang[psychology_student]</td>
                        <td class="only18">#psychology_student#</td>
                </tr>

		<tr>
                        <td class="only18">lang[student_from_this_university]</td>
                        <td class="only18">#student_from_this_university#</td>
                </tr>

		<tr>
                        <td>lang[level_of_education]</td>
                        <td>#level_of_education#</td>
                </tr>

		<tr>
                        <td>lang[date_of_birth]</td>
                        <td>lang[day]#day_of_birth#lang[month]#month_of_birth#lang[year]#year_of_birth#</td>
                </tr>

	

		<tr>
                        <td>lang[preferred_hand]</td>
                        <td>#preferred_hand#</td>
                </tr>

		<tr>
                        <td>lang[native_tongue]</td>
                        <td>#native_tongue#</td>
                </tr>

		<tr>
                        <td>lang[second_tongue]</td>
                        <td>#second_tongue#</td>
                </tr>

		<tr>
                        <td>lang[second_tongue_fluency]</td>
                        <td>#second_tongue_fluency#</td>
                </tr>

		<tr>
                        <td>lang[visual_impairments]</td>
                        <td>#visual_impairments#</td>
                </tr>

		<tr>
                        <td>lang[auditory_impairments]</td>
                        <td>#auditory_impairments#</td>
                </tr>

		<tr>
                        <td>lang[biological_disorder]</td>
                        <td>#biological_disorder#</td>
                </tr>

		<tr>
                        <td>lang[psycological_disorder]</td>
                        <td>#psycological_disorder#</td>
                </tr>

		<tr>
                        <td>lang[plays_sports_often]</td>
                        <td>#plays_sports_often#</td>
                </tr>

		<tr>
                        <td class="only18">lang[lives_with_someone]</td>
                        <td class="only18">#lives_with_someone#</td>
                </tr>

		<tr>
                        <td class="only-parent">lang[children]</td>
                        <td class="only-parent">#children#</td>
                </tr>
					

	
		{ #is_subpool_type_b#
                <tr>
			
			<!--			<td class="only-parent" #error_field_of_studies#>lang[studies]<br />#field_of_studies#</td>

        					<td class="only-parent" align="center">&nbsp;lang[or]&nbsp;</td>
-->
						<td class="only-parent" #error_profession#>lang[profession]</td><td class="only-parent">#profession#</td>
					</tr>
			<!--		<tr>
						<td #error_begin_of_studies#>lang[begin_of_studies]<br />#begin_of_studies#</td>
						<td colspan="2"></td>
					</tr>-->
				
			
                </tr> }
<!--
		{ #is_subpool_type_s#
                <tr #error_field_of_studies#>
                        <td>lang[studies]</td>
                        <td>#field_of_studies#</td>
		</tr>-->
<!--
		<tr #error_begin_of_studies#>
			<td>lang[begin_of_studies]</td>
			<td>#begin_of_studies#</td>
                </tr> -->
}

<!--		{ #is_subpool_type_w#
                <tr #error_profession#>
                        <td>lang[profession]</td>
                        <td>#profession#</td>
                </tr> }-->
                <script>
$(function() {
    $("[name=underage]").click(function(){
            $('.toHide').toggle();
			$('.only-parent').toggle();
			$('.only18').toggle();
    });
 });
 </script>