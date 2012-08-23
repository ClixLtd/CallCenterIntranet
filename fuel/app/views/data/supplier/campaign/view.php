<h2>Viewing #<?php echo $data_supplier_campaign->id; ?></h2>

<p>
	<strong>Data supplier id:</strong>
	<?php echo $data_supplier_campaign->data_supplier_id; ?></p>
<p>
	<strong>Title:</strong>
	<?php echo $data_supplier_campaign->title; ?></p>
<p>
	<strong>Description:</strong>
	<?php echo $data_supplier_campaign->description; ?></p>

<?php echo Html::anchor('data/supplier/campaign/edit/'.$data_supplier_campaign->id, 'Edit'); ?> |
<?php echo Html::anchor('data/supplier/campaign', 'Back'); ?>