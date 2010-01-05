<?
$days = array(
	"0"  => "Sun",
	"1"  => "Mon",
	"2"  => "Tue",
	"3"  => "Wed",
	"4"  => "Thu",
	"5"  => "Fri",
	"6"  => "Sat",

);

if ($_advanced_view)
{
	
?>


<form enctype="multipart/form-data"  action="/users/email_pref_save" method="post" name="form_edit" >
<table id="formTable" >
<input type="hidden" name="_user_id" value="<?= $_user_id ?>" />

	<tr>
		<td class="fTitle">Email Subscribe:</td>
		<td> 
			<select name="_email_subscribe" >
				<option value="1" <?php if ($_email_subscribe==1) {echo 'SELECTED';} ?>  >Active</option>		
				<option value="0" <?php if ($_email_subscribe==0) {echo 'SELECTED';} ?>>Inactive</option>						
			</select>
		</td>
	</tr>	
	<tr>
		<td class="fTitle">Email Days:</td>
		<td>
			<? for ( $i = 0; $i <= 6; $i ++) { ?>
				<input type="checkbox" name="_email_days[]" <? if (substr_count($_email_days, $i) > 0) echo 'CHECKED'  ?> value="<?= $i ?>" ><?= $days[$i] ?>&nbsp;&nbsp;
			<? } ?>
		</td>
	</tr>
	<tr>
		<td class="fTitle">Email Hours:</td>
		<td>
			<select name="_email_hours[]" MULTIPLE size="10">
			<? $_email_hours .= ",";
				for ( $i = 0; $i <= 23; $i ++) { ?>
				<option value="<?= $i ?>" <? if (substr_count($_email_hours, $i.",") > 0) echo 'SELECTED'  ?> ><?= $i ?>:00 </option>
			<? } ?>
		</td>
	</tr>	

	<tr>
		<td class="fTitle">type:</td>
		<td>
					<select name="_email_param_date" >
						<option value="day" <?php if ($_email_param_date=='day') {echo 'SELECTED';} ?>  >day</option>
						<option value="week" <?php if ($_email_param_date=='week') {echo 'SELECTED';} ?>  >week</option>		
						<option value="month" <?php if ($_email_param_date=='month') {echo 'SELECTED';} ?>  >month</option>								
					</select>
		</td>
	</tr>	

		


</tbody>	
<tfoot>
	<tr>
		<td colspan="2">
		<a class="genericBtn" id="bSubmit" href="javascript:snackFeed.tempFunctions.saveForm()">save</a>
		</td>
	</tr>
</tfoot>
</table>

<script>


snackFeed.tempFunctions.saveForm = function() {
	
	snackFeed.formController.submit( 'form_edit' , '/users/email_pref_save' , welcomeView.renderNewUserDone );
}


</script>

</form>

<?

} else {

?>

<form enctype="multipart/form-data"  action="/users/email_pref_save" method="post" name="form_edit" >
	
<input type="hidden" name="_user_id" value="<?= $_user_id ?>" />
<input type="hidden" name="_email_subscribe" value="1" />
<input type="hidden" name="_email_days[]" value="<?= $_email_days ?>" />
<input type="hidden" name="_email_hours[]" value="5" />	

	<h3 style="padding-bottom:20px">How often do you want snackFeed?</h3>
		<a class="genericBtn" id="bSubmit" href="javascript:snackFeed.tempFunctions.saveForm('0,1,2,3,4,5,6',1)">Daily</a>
	
		<a class="genericBtn" id="bSubmit" href="javascript:snackFeed.tempFunctions.saveForm('1,2,3,4,5',1)">Weekdays</a>

		<a class="genericBtn" id="bSubmit" href="javascript:snackFeed.tempFunctions.saveForm('1',1)">Weekly</a>
		<? if($_email_subscribe == 1){ ?>
		<a class="genericBtn" id="bSubmit" href="javascript:snackFeed.tempFunctions.saveForm('',0)">Unsubscribe</a>
		<? } ?>
	
		<a class="genericBtn" id="bSubmit" href="javascript:welcomeView.renderNewUserEmailPrefsAdv()">Advanced View</a>

</form>


<script>


snackFeed.tempFunctions.saveForm = function(_days, _subscribe) {
	
	var f = document.form_edit;
	f.elements['_email_days[]'].value = _days;
	f.elements['_email_subscribe'].value = _subscribe;
	snackFeed.formController.submit( 'form_edit' , '/users/email_pref_save' , welcomeView.renderNewUserDone );
}


</script>





<?

}

?>

