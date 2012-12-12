<h2>Viewing #<?php echo $adam_message->id; ?></h2>

<p>
	<strong>Message:</strong>
	<?php echo $adam_message->message; ?></p>

<?php echo Html::anchor('adam/messages/edit/'.$adam_message->id, 'Edit'); ?> |
<?php echo Html::anchor('adam/messages', 'Back'); ?>