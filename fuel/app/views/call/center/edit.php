<h2>Editing Call_center</h2>
<br>

<?php echo render('call/center/_form'); ?>
<p>
	<?php echo Html::anchor('call/center/view/'.$call_center->id, 'View'); ?> |
	<?php echo Html::anchor('call/center', 'Back'); ?></p>
