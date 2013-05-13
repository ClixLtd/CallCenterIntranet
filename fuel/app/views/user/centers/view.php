<h2>Viewing #<?php echo $user_center->id; ?></h2>

<p>
	<strong>User:</strong>
	<?php echo $user_center->user; ?></p>
<p>
	<strong>Center:</strong>
	<?php echo $user_center->center; ?></p>

<?php echo Html::anchor('user/centers/edit/'.$user_center->id, 'Edit'); ?> |
<?php echo Html::anchor('user/centers', 'Back'); ?>