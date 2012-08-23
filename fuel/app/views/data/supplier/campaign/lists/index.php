<h2>Listing Data_supplier_campaign_lists</h2>
<br>
<?php if ($data_supplier_campaign_lists): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Data supplier campaign id</th>
			<th>List id</th>
			<th>Database server id</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($data_supplier_campaign_lists as $data_supplier_campaign_list): ?>		<tr>

			<td><?php echo $data_supplier_campaign_list->data_supplier_campaign_id; ?></td>
			<td><?php echo $data_supplier_campaign_list->list_id; ?></td>
			<td><?php echo $data_supplier_campaign_list->database_server_id; ?></td>
			<td>
				<?php echo Html::anchor('data/supplier/campaign/lists/view/'.$data_supplier_campaign_list->id, 'View'); ?> |
				<?php echo Html::anchor('data/supplier/campaign/lists/edit/'.$data_supplier_campaign_list->id, 'Edit'); ?> |
				<?php echo Html::anchor('data/supplier/campaign/lists/delete/'.$data_supplier_campaign_list->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Data_supplier_campaign_lists.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('data/supplier/campaign/lists/create', 'Add new Data supplier campaign list', array('class' => 'btn success')); ?>

</p>
