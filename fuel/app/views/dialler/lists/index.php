<h2>Listing Dialler_lists</h2>
<br>
<?php if ($dialler_lists): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>List name</th>
			<th>List description</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($dialler_lists as $dialler_list): ?>		<tr>

			<td><?php echo $dialler_list->list_name; ?></td>
			<td><?php echo $dialler_list->list_description; ?></td>
			<td>
				<?php echo Html::anchor('dialler/lists/view/'.$dialler_list->id, 'View'); ?> |
				<?php echo Html::anchor('dialler/lists/edit/'.$dialler_list->id, 'Edit'); ?> |
				<?php echo Html::anchor('dialler/lists/delete/'.$dialler_list->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Dialler_lists.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('dialler/lists/create', 'Add new Dialler list', array('class' => 'btn success')); ?>

</p>
