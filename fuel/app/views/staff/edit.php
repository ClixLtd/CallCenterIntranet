<h2>Editing Staff</h2>
<br>

<?php echo render('staff/_form'); ?>
<p>
	<?php echo Html::anchor('staff/view/'.$staff->id, 'View'); ?> |
	<?php echo Html::anchor('staff', 'Back'); ?></p>
