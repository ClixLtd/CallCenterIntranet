<h2>Viewing #<?php echo $proxy->id; ?></h2>

<p>
	<strong>Host:</strong>
	<?php echo $proxy->host; ?></p>
<p>
	<strong>Port:</strong>
	<?php echo $proxy->port; ?></p>
<p>
	<strong>Fail count:</strong>
	<?php echo $proxy->fail_count; ?></p>

<?php echo Html::anchor('proxies/edit/'.$proxy->id, 'Edit'); ?> |
<?php echo Html::anchor('proxies', 'Back'); ?>