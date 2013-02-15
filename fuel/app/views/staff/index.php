<h2>Listing Staffs</h2>
<br>
<?php if ($staffs): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>First name</th>
			<th>Last name</th>
			<th>Intranet id</th>
			<th>Dialler id</th>
			<th>Debtsolv id</th>
			<th>Network id</th>
			<th>Department</th>
			<th>Center</th>
			<th>Active</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($staffs as $staff): ?>		<tr>

			<td><?php echo $staff->first_name; ?></td>
			<td><?php echo $staff->last_name; ?></td>
			<td><?php echo $staff->intranet_id; ?></td>
			<td><?php echo $staff->dialler_id; ?></td>
			<td><?php echo $staff->debtsolv_id; ?></td>
			<td><?php echo $staff->network_id; ?></td>
			<td><?php echo $staff->department_id; ?></td>
			<td><?php echo $staff->center_id; ?></td>
			<td><?php echo $staff->active; ?></td>
			<td>
				<?php echo Html::anchor('staff/view/'.$staff->id, 'View'); ?> |
				<?php echo Html::anchor('staff/edit/'.$staff->id, 'Edit'); ?> |
				<?php echo Html::anchor('staff/delete/'.$staff->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Staffs.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('staff/create', 'Add new Staff', array('class' => 'btn success')); ?>

</p>
