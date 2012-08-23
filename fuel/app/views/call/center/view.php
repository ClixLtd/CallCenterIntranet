<h2>Viewing #<?php echo $call_center->id; ?></h2>

<p>
	<strong>Title:</strong>
	<?php echo $call_center->title; ?></p>
<p>
	<strong>Address:</strong>
	<?php echo $call_center->address; ?></p>
<p>
	<strong>Phone number:</strong>
	<?php echo $call_center->phone_number; ?></p>

<?php echo Html::anchor('call/center/edit/'.$call_center->id, 'Edit'); ?> |
<?php echo Html::anchor('call/center', 'Back'); ?>