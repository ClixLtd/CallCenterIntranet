<h2>Editing Dialler_list</h2>
<br>

<?php echo render('dialler/lists/_form'); ?>
<p>
	<?php echo Html::anchor('dialler/lists/view/'.$dialler_list->id, 'View'); ?> |
	<?php echo Html::anchor('dialler/lists', 'Back'); ?></p>
