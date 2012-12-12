<h2>Viewing #<?php echo $api_user->id; ?></h2>

<p>
	<strong>Id:</strong>
	<?php echo $api_user->id; ?></p>
<p>
	<strong>Key:</strong>
	<?php echo $api_user->key; ?></p>
<p>
	<strong>Status:</strong>
	<?php echo $api_user->status; ?></p>
<p>
	<strong>Description:</strong>
	<?php echo $api_user->description; ?></p>
<p>
	<strong>Ip:</strong>
	<?php echo $api_user->ip; ?></p>

<?php echo Html::anchor('api/users/edit/'.$api_user->id, 'Edit'); ?> |
<?php echo Html::anchor('api/users', 'Back'); ?>