<h2>Viewing #<?php echo $data_supplier_list->id; ?></h2>

<p>
	<strong>Data supplier id:</strong>
	<?php echo $data_supplier_list->data_supplier_id; ?></p>
<p>
	<strong>Datafile:</strong>
	<?php echo $data_supplier_list->datafile; ?></p>
<p>
	<strong>Cost:</strong>
	<?php echo $data_supplier_list->cost; ?></p>
<p>
	<strong>Total leads:</strong>
	<?php echo $data_supplier_list->total_leads; ?></p>

<?php echo Html::anchor('data/supplier/list/edit/'.$data_supplier_list->id, 'Edit'); ?> |
<?php echo Html::anchor('data/supplier/list', 'Back'); ?>