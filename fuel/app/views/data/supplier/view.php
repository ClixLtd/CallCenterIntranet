<h2>Viewing #<?php echo $data_supplier->id; ?></h2>

<p>
	<strong>Company name:</strong>
	<?php echo $data_supplier->company_name; ?></p>
<p>
	<strong>Contact name:</strong>
	<?php echo $data_supplier->contact_name; ?></p>
<p>
	<strong>Contact email:</strong>
	<?php echo $data_supplier->contact_email; ?></p>
<p>
	<strong>Contact address:</strong>
	<?php echo $data_supplier->contact_address; ?></p>
<p>
	<strong>Web address:</strong>
	<?php echo $data_supplier->web_address; ?></p>
<p>
	<strong>Telephone:</strong>
	<?php echo $data_supplier->telephone; ?></p>
<p>
	<strong>Mobile:</strong>
	<?php echo $data_supplier->mobile; ?></p>
<p>
	<strong>Fax:</strong>
	<?php echo $data_supplier->fax; ?></p>

<?php echo Html::anchor('data/supplier/edit/'.$data_supplier->id, 'Edit'); ?> |
<?php echo Html::anchor('data/supplier', 'Back'); ?>