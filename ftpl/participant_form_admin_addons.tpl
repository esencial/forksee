
        <tr>
            <td>lang[id]</td>
            <td>#participant_id# (#participant_id_crypt#)</td>
        </tr>

		<tr>
            <td>lang[time]</td>
            <td>#creation_time#</td>
        </tr>
	
		<tr>
            <td>lang[subpool]</td>
            <td>#subpool_id#</td>
        </tr>

	<tr>
              <td>lang[banned]</td>
              <td>#banned#</td>
        </tr>
        <tr>
              <td class="hideBanned">SUSTITUIR POR LANG</td>
              <td class="hideBanned">lang[day]#ban_start_day#lang[month]#ban_start_month#lang[year]#ban_start_year#</td>
        </tr>
        <tr>
              <td class="hideBanned">SUSTITUIR POR LANG</td>
              <td class="hideBanned">lang[day]#ban_end_day#lang[month]#ban_end_month#lang[year]#ban_end_year#</td>
        </tr>
        
       <!-- <tr>
         <td class="hideBanned">lang[how_long]</td>
         <td class="hideBanned">#banned_amount##banned_unit#</td>
      </tr>-->

		<tr>
            <td>lang[rules_signed]</td>
            <td>#rules_signed#</td>
        </tr>

		<tr>
            <td>lang[remarks]</td>
            <td>#remarks#</td>
        </tr>

		<tr>
            <td colspan="2">&nbsp;</td>
        </tr>

	{ #is_part_create_form#
		<tr>
            <td colspan=2 align=left>
				#checkbox_add_to_session# lang[register_sub_for_session] 
                #select_add_to_session#
            </td> }
        </tr>


<script>
    $(function() {
    $("[name=banned]").click(function(){
            $('.hideBanned').toggle();
        });
    });
    
        
 
 </script>
