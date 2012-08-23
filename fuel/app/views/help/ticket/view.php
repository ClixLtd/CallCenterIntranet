<h2>Viewing #<?php echo $help_ticket->id; ?></h2>

<p>
	<strong>Title:</strong>
	<?php echo $help_ticket->title; ?></p>
<p>
	<strong>Description:</strong>
	<?php echo $help_ticket->description; ?></p>
<p>
	<strong>Priority:</strong>
	<?php echo $help_ticket->priority; ?></p>
<p>
	<strong>Help topic id:</strong>
	<?php echo $help_ticket->help_topic_id; ?></p>
<p>
	<strong>User id:</strong>
	<?php echo $help_ticket->user_id; ?></p>

<?php echo Html::anchor('help/ticket/edit/'.$help_ticket->id, 'Edit'); ?> |
<?php echo Html::anchor('help/ticket', 'Back'); ?>