







<form name="form_filter" action="/?a=reports.users" method="POST">
	
<table width="80%">
	<tr>
		<td>
		
	
	<select name="date_range">
		<option value="day" <? if ($_date_range == 'day') echo 'SELECTED'; ?> >today</option>
		<option value="week" <? if ($_date_range == 'week') echo 'SELECTED'; ?> >this week</option>
		<option value="month" <? if ($_date_range == 'month') echo 'SELECTED'; ?> >this month</option>				
	</select>




	


	[<a href="javascript:document.form_filter.submit()">filter</a>]
	
	</td>
	</tr>
</table>

	
	
</form>

<table id="zTable">

<thead>
	<th>total users</th>
	<th>new users</th>
	<th>recent logins</th>
</thead>
<tbody>







<tr>
<td style="text-align:left;"><?=  $q[0]['total_users']; ?></td>
<td style="text-align:left;"><?=  $q[0]['new_users']; ?></td>
<td style="text-align:left;"><?=  $q[0]['recent_logins']; ?></td>
</tr>

</tbody>


</table>



