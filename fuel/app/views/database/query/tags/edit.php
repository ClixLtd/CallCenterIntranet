<h2>Editing Database_query_tag</h2>
<br>

<?php echo render('database/query/tags/_form'); ?>
<p>
	<?php echo Html::anchor('database/query/tags/view/'.$database_query_tag->id, 'View'); ?> |
	<?php echo Html::anchor('database/query/tags', 'Back'); ?></p>
