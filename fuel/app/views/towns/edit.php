<h2>Editing Town</h2>
<br>

<?php echo render('towns/_form'); ?>
<p>
	<?php echo Html::anchor('towns/view/'.$town->id, 'View'); ?> |
	<?php echo Html::anchor('towns', 'Back'); ?></p>
