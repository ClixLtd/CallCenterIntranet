<h2>Listing Data_suppliers</h2>
<br>
<?php if ($data_suppliers): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Company name</th>
			<th>Contact name</th>
			<th>Contact email</th>
			<th>Contact address</th>
			<th>Web address</th>
			<th>Telephone</th>
			<th>Mobile</th>
			<th>Fax</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($data_suppliers as $data_supplier): ?>		<tr>

			<td><?php echo $data_supplier->company_name; ?></td>
			<td><?php echo $data_supplier->contact_name; ?></td>
			<td><?php echo $data_supplier->contact_email; ?></td>
			<td><?php echo $data_supplier->contact_address; ?></td>
			<td><?php echo $data_supplier->web_address; ?></td>
			<td><?php echo $data_supplier->telephone; ?></td>
			<td><?php echo $data_supplier->mobile; ?></td>
			<td><?php echo $data_supplier->fax; ?></td>
			<td>
				<?php echo Html::anchor('data/supplier/view/'.$data_supplier->id, 'View'); ?> |
				<?php echo Html::anchor('data/supplier/edit/'.$data_supplier->id, 'Edit'); ?> |
				<?php echo Html::anchor('data/supplier/delete/'.$data_supplier->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Data_suppliers.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('data/supplier/create', 'Add new Data supplier', array('class' => 'btn success')); ?>

</p>
