<h2>Editing User_center</h2>
<br>

<?php echo render('user/centers/_form'); ?>
<p>
	<?php echo Html::anchor('user/centers/view/'.$user_center->id, 'View'); ?> |
	<?php echo Html::anchor('user/centers', 'Back'); ?></p>
