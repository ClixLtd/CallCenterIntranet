<h2>Editing Api_user</h2>
<br>

<?php echo render('api/users/_form'); ?>
<p>
	<?php echo Html::anchor('api/users/view/'.$api_user->id, 'View'); ?> |
	<?php echo Html::anchor('api/users', 'Back'); ?></p>
