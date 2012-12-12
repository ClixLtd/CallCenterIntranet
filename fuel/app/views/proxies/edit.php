<h2>Editing Proxy</h2>
<br>

<?php echo render('proxies/_form'); ?>
<p>
	<?php echo Html::anchor('proxies/view/'.$proxy->id, 'View'); ?> |
	<?php echo Html::anchor('proxies', 'Back'); ?></p>
