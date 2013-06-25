<div class="container">
       
	<table class="datatable">
		<thead>
			<tr>
				<th>List ID</th>
				<th>Date</th>
				<th>Purchased</th>
				<th>Dialable</th>
				<th>Contacted</th>
				<th>Referrals</th>
				<th>Pack Out</th>
				<th>Pack In</th>
				<th>Paid</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($lists as $list): ?>
			<tr>
				<td><?php echo $list['dialler_id']; ?></td>
				<td><?php echo date("d/m/Y", strtotime($list['added_date'])); ?></td>
				<td><?php echo $list['purchased_leads']; ?></td>
				<td><?php echo $list['dialable_leads']; ?></td>
				<td><?php echo $list['contacted_leads']; ?></td>
				<td><?php echo $list['referrals']; ?></td>
				<td><?php echo $list['pack_out']; ?></td>
				<td><?php echo $list['pack_in']; ?></td>
				<td><?php echo $list['first_payment']; ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

</div>