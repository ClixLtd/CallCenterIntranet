<h2>Viewing #<?php echo $database_query_tag->id; ?></h2>

<p>
	<strong>Database query id:</strong>
	<?php echo $database_query_tag->database_query_id; ?></p>
<p>
	<strong>Tag:</strong>
	<?php echo $database_query_tag->tag; ?></p>

<?php echo Html::anchor('database/query/tags/edit/'.$database_query_tag->id, 'Edit'); ?> |
<?php echo Html::anchor('database/query/tags', 'Back'); ?>