<h2>Viewing #<?php echo $data_supplier_campaign_lists_duplicate->id; ?></h2>

<p>
	<strong>List id:</strong>
	<?php echo $data_supplier_campaign_lists_duplicate->list_id; ?></p>
<p>
	<strong>Database server id:</strong>
	<?php echo $data_supplier_campaign_lists_duplicate->database_server_id; ?></p>
<p>
	<strong>Duplicate number:</strong>
	<?php echo $data_supplier_campaign_lists_duplicate->duplicate_number; ?></p>

<?php echo Html::anchor('data/supplier/campaign/lists/duplicates/edit/'.$data_supplier_campaign_lists_duplicate->id, 'Edit'); ?> |
<?php echo Html::anchor('data/supplier/campaign/lists/duplicates', 'Back'); ?>