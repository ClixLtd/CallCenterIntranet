<h2>Viewing #<?php echo $proxy_import->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $proxy_import->name; ?></p>
<p>
	<strong>Proxylist:</strong>
	<?php echo $proxy_import->proxylist; ?></p>

<?php echo Html::anchor('proxy/import/edit/'.$proxy_import->id, 'Edit'); ?> |
<?php echo Html::anchor('proxy/import', 'Back'); ?>