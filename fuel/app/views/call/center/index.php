<h2>Listing Call_centers</h2>
<br>
<?php if ($call_centers): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Title</th>
			<th>Address</th>
			<th>Phone number</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($call_centers as $call_center): ?>		<tr>

			<td><?php echo $call_center->title; ?></td>
			<td><?php echo $call_center->address; ?></td>
			<td><?php echo $call_center->phone_number; ?></td>
			<td>
				<?php echo Html::anchor('call/center/view/'.$call_center->id, 'View'); ?> |
				<?php echo Html::anchor('call/center/edit/'.$call_center->id, 'Edit'); ?> |
				<?php echo Html::anchor('call/center/delete/'.$call_center->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Call_centers.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('call/center/create', 'Add new Call center', array('class' => 'btn success')); ?>

</p>
