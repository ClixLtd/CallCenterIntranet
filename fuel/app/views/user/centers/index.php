<h2>Listing User_centers</h2>
<br>
<?php if ($user_centers): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>User</th>
			<th>Center</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($user_centers as $user_center): ?>		<tr>

			<td><?php echo $user_center->user; ?></td>
			<td><?php echo $user_center->center; ?></td>
			<td>
				<?php echo Html::anchor('user/centers/view/'.$user_center->id, 'View'); ?> |
				<?php echo Html::anchor('user/centers/edit/'.$user_center->id, 'Edit'); ?> |
				<?php echo Html::anchor('user/centers/delete/'.$user_center->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No User_centers.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('user/centers/create', 'Add new User center', array('class' => 'btn success')); ?>

</p>
