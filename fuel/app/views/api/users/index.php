<h2>Listing Api_users</h2>
<br>
<?php if ($api_users): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Id</th>
			<th>Key</th>
			<th>Status</th>
			<th>Description</th>
			<th>Ip</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($api_users as $api_user): ?>		<tr>

			<td><?php echo $api_user->id; ?></td>
			<td><?php echo $api_user->key; ?></td>
			<td><?php echo $api_user->status; ?></td>
			<td><?php echo $api_user->description; ?></td>
			<td><?php echo $api_user->ip; ?></td>
			<td>
				<?php echo Html::anchor('api/users/view/'.$api_user->id, 'View'); ?> |
				<?php echo Html::anchor('api/users/edit/'.$api_user->id, 'Edit'); ?> |
				<?php echo Html::anchor('api/users/delete/'.$api_user->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Api_users.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('api/users/create', 'Add new Api user', array('class' => 'btn success')); ?>

</p>
