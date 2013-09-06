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
                <th>Score</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($lists as $list): ?>
			<tr>
				<td><a href="/data/view/<?php echo $list['id']; ?>"><?php echo $list['dialler_id']; ?></a></td>
				<td><?php echo date("d/m/Y", strtotime($list['added_date'])); ?></td>
				<td><?php echo $list['purchased_leads']; ?></td>
				<td><span rel="tooltip" title="<?php echo number_format((((int)$list['dialable_leads']/(int)$list['purchased_leads'])*100),2)."%"; ?>"><?php echo $list['dialable_leads']; ?></span></td>
				<td><span rel="tooltip" title="<?php echo number_format((((int)$list['contacted_leads']/(int)$list['dialable_leads'])*100),2)."%"; ?>"><?php echo $list['contacted_leads']; ?></span></td>
				<td><span rel="tooltip" title="<?php echo number_format((((int)$list['referrals']/(int)$list['contacted_leads'])*100),2)."%"; ?>"><?php echo $list['referrals']; ?></span></td>
				<td><span rel="tooltip" title="<?php echo number_format((((int)$list['pack_out']/(int)$list['referrals'])*100),2)."%"; ?>"><?php echo $list['pack_out']; ?></span></td>
				<td><span rel="tooltip" title="<?php echo number_format((((int)$list['pack_in']/(int)$list['pack_out'])*100),2)."%"; ?>"><?php echo $list['pack_in']; ?></span></td>
                <td><span rel="tooltip" title="<?php echo number_format((((int)$list['first_payment']/(int)$list['pack_in'])*100),2)."%"; ?>"><?php echo $list['first_payment']; ?></span></td>
                <td><?php echo ($list['score'] / $list['purchased_leads']); ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

</div>