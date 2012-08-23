<h2>Editing Help_ticket</h2>
<br>

<?php echo render('help/ticket/_form'); ?>
<p>
	<?php echo Html::anchor('help/ticket/view/'.$help_ticket->id, 'View'); ?> |
	<?php echo Html::anchor('help/ticket', 'Back'); ?></p>
