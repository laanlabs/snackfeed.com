

<? include "_inc/edit.php" ?>


<style type="text/css" media="screen">
	.fTitle
	{
		text-align: right;
	}
	#formTable
	{
		padding: 5px;
	}
	
	#formTable td
	{
		padding: 5px;
	}
	
</style>


<div  class="middle-column ">
	
	<div class="header-big">
		your alerts
	</div>
	
	<div class="indent-column">
		

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

		<h3 style="padding-bottom:20px; padding-top: 20px">Advanced view for how often do you want snackfeed emails?</h3>

		<form enctype="multipart/form-data"  action="/users/alerts" method="post" name="form_edit" >
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
				<td></td>
				<td >
				<div style="height:20px"></div>	
				<a class="btn-normal" id="bSubmit" href="javascript:document.form_edit.submit">save</a>
					<a class="btn-normal" id="bSubmit" href="/users/alerts">Basic View</a>
				</td>
			</tr>
		</tfoot>
		</table>

		</form>

		<?

		} else {

		?>

		<form enctype="multipart/form-data"  action="/users/alerts" method="post" name="form_edit" >
				
		
		<input type="hidden" name="_user_id" value="<?= $_user_id ?>" />
		<input type="hidden" name="_email_subscribe" value="1" />
		<input type="hidden" name="_email_days[]" value="<?= $_email_days ?>" />
		<input type="hidden" name="_email_hours[]" value="5" />	

			<h3 style="padding-bottom:40px; padding-top: 20px">How often do you want snackFeed?</h3>
				<a class="btn-normal" id="bSubmit" href="javascript:saveForm('0,1,2,3,4,5,6',1)">Daily</a>
				<a class="btn-normal" id="bSubmit" href="javascript:saveForm('1,2,3,4,5',1)">Weekdays</a>
				<a class="btn-normal" id="bSubmit" href="javascript:saveForm('1',1)">Weekly</a>

				<? if($_email_subscribe == 1){ ?>
				<a class="btn-normal" id="bSubmit" href="javascript:saveForm('',0)">Unsubscribe</a>
				<? } ?>

				<a class="btn-normal" id="bSubmit" href="/users/alerts/?adv=true">Advanced View</a>

		</form>


		<script>


		function saveForm(_days, _subscribe) {

			var f = document.form_edit;
			f.elements['_email_days[]'].value = _days;
			f.elements['_email_subscribe'].value = _subscribe;
			document.form_edit.submit();
		}


		</script>





		<?

		}

		?>



		
					
		
		
	</div>
</div>