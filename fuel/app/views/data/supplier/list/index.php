<h2>Listing Data_supplier_lists</h2>
<br>
<?php if ($data_supplier_lists): ?>
<table class="zebra-striped datatable">
	<thead>
		<tr>
			<th>Data supplier id</th>
			<th>Title</th>
			<th>Cost</th>
			<th>Total leads</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($data_supplier_lists as $data_supplier_list): ?>		<tr>

			<td><?php echo $data_supplier_list->data_supplier_id; ?></td>
			<td><?php echo $data_supplier_list->title; ?></td>
			<td><?php echo $data_supplier_list->cost; ?></td>
			<td><?php echo $data_supplier_list->total_leads; ?></td>
			<td>
				<?php echo Html::anchor('data/supplier/list/view/'.$data_supplier_list->id, 'View'); ?> |
				<?php echo Html::anchor('data/supplier/list/edit/'.$data_supplier_list->id, 'Edit'); ?> |
				<?php echo Html::anchor('data/supplier/list/delete/'.$data_supplier_list->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Data_supplier_lists.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('data/supplier/list/create', 'Add new Data supplier list', array('class' => 'btn success')); ?>

</p>
