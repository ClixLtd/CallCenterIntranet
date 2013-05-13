<h2>Listing Staff_departments</h2>
<br>
<?php if ($staff_departments): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Title</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($staff_departments as $staff_department): ?>		<tr>

			<td><?php echo $staff_department->title; ?></td>
			<td>
				<?php echo Html::anchor('staff/department/view/'.$staff_department->id, 'View'); ?> |
				<?php echo Html::anchor('staff/department/edit/'.$staff_department->id, 'Edit'); ?> |
				<?php echo Html::anchor('staff/department/delete/'.$staff_department->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Staff_departments.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('staff/department/create', 'Add new Staff department', array('class' => 'btn success')); ?>

</p>
