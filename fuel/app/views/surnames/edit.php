<h2>Editing Surname</h2>
<br>

<?php echo render('surnames/_form'); ?>
<p>
	<?php echo Html::anchor('surnames/view/'.$surname->id, 'View'); ?> |
	<?php echo Html::anchor('surnames', 'Back'); ?></p>
