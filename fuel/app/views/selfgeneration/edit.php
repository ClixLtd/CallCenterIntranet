<h2>Editing Selfgeneration</h2>
<br>

<?php echo render('selfgeneration/_form'); ?>
<p>
	<?php echo Html::anchor('selfgeneration/view/'.$selfgeneration->id, 'View'); ?> |
	<?php echo Html::anchor('selfgeneration', 'Back'); ?></p>
