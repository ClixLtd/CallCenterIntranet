<h2>Editing Lead_table</h2>
<br>

<?php echo render('lead/table/_form'); ?>
<p>
	<?php echo Html::anchor('lead/table/view/'.$lead_table->id, 'View'); ?> |
	<?php echo Html::anchor('lead/table', 'Back'); ?></p>
