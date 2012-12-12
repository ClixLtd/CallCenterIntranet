<h2>Listing Data_supplier_campaign_lists_duplicates</h2>
<br>
<?php if ($data_supplier_campaign_lists_duplicates): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>List id</th>
			<th>Database server id</th>
			<th>Duplicate number</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($data_supplier_campaign_lists_duplicates as $data_supplier_campaign_lists_duplicate): ?>		<tr>

			<td><?php echo $data_supplier_campaign_lists_duplicate->list_id; ?></td>
			<td><?php echo $data_supplier_campaign_lists_duplicate->database_server_id; ?></td>
			<td><?php echo $data_supplier_campaign_lists_duplicate->duplicate_number; ?></td>
			<td>
				<?php echo Html::anchor('data/supplier/campaign/lists/duplicates/view/'.$data_supplier_campaign_lists_duplicate->id, 'View'); ?> |
				<?php echo Html::anchor('data/supplier/campaign/lists/duplicates/edit/'.$data_supplier_campaign_lists_duplicate->id, 'Edit'); ?> |
				<?php echo Html::anchor('data/supplier/campaign/lists/duplicates/delete/'.$data_supplier_campaign_lists_duplicate->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Data_supplier_campaign_lists_duplicates.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('data/supplier/campaign/lists/duplicates/create', 'Add new Data supplier campaign lists duplicate', array('class' => 'btn success')); ?>

</p>
