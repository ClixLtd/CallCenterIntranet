<h2>Listing Data_supplier_campaigns</h2>
<br>
<?php if ($data_supplier_campaigns): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Data supplier id</th>
			<th>Title</th>
			<th>Description</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($data_supplier_campaigns as $data_supplier_campaign): ?>		<tr>

			<td><?php echo $data_supplier_campaign->data_supplier_id; ?></td>
			<td><?php echo $data_supplier_campaign->title; ?></td>
			<td><?php echo $data_supplier_campaign->description; ?></td>
			<td>
				<?php echo Html::anchor('reports/supplier/'.$data_supplier_campaign->id, 'View'); ?> |
				<?php echo Html::anchor('data/supplier/campaign/edit/'.$data_supplier_campaign->id, 'Edit'); ?> |
				<?php echo Html::anchor('data/supplier/campaign/delete/'.$data_supplier_campaign->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Data_supplier_campaigns.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('data/supplier/campaign/create', 'Add new Data supplier campaign', array('class' => 'btn success')); ?>

</p>
