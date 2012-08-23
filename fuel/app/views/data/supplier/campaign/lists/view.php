<h2>Viewing #<?php echo $data_supplier_campaign_list->id; ?></h2>

<p>
	<strong>Data supplier campaign id:</strong>
	<?php echo $data_supplier_campaign_list->data_supplier_campaign_id; ?></p>
<p>
	<strong>List id:</strong>
	<?php echo $data_supplier_campaign_list->list_id; ?></p>
<p>
	<strong>Database server id:</strong>
	<?php echo $data_supplier_campaign_list->database_server_id; ?></p>

<?php echo Html::anchor('data/supplier/campaign/lists/edit/'.$data_supplier_campaign_list->id, 'Edit'); ?> |
<?php echo Html::anchor('data/supplier/campaign/lists', 'Back'); ?>