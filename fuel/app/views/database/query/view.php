<h2>Viewing #<?php echo $database_query->id; ?></h2>

<p>
	<strong>Title:</strong>
	<?php echo $database_query->title; ?></p>
<p>
	<strong>Description:</strong>
	<?php echo $database_query->description; ?></p>
<p>
	<strong>Query:</strong>
	<?php echo $database_query->query; ?></p>
<p>
	<strong>Server:</strong>
	<?php echo $database_query->database_servers->title; ?></p>
<p>
	<strong>Database:</strong>
	<?php echo $database_query->database; ?></p>
<p>
	<strong>Username:</strong>
	<?php echo $database_query->username; ?></p>
<p>
	<strong>Password:</strong>
	<?php echo $database_query->password; ?></p>

<?php echo Html::anchor('database/query/edit/'.$database_query->id, 'Edit'); ?> |
<?php echo Html::anchor('database/query', 'Back'); ?>