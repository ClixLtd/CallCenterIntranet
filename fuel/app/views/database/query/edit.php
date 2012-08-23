<h2>Editing Database_query</h2>
<br>

<?php echo render('database/query/_form'); ?>
<p>
	<?php echo Html::anchor('database/query/view/'.$database_query->id, 'View'); ?> |
	<?php echo Html::anchor('database/query', 'Back'); ?></p>
