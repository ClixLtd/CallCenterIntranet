<h2>Viewing #<?php echo $news->id; ?></h2>

<p>
	<strong>Title:</strong>
	<?php echo $news->title; ?></p>
<p>
	<strong>Article:</strong>
	<?php echo $news->article; ?></p>
<p>
	<strong>Call center id:</strong>
	<?php echo $news->call_center_id; ?></p>
<p>
	<strong>User id:</strong>
	<?php echo $news->user_id; ?></p>

<?php echo Html::anchor('news/edit/'.$news->id, 'Edit'); ?> |
<?php echo Html::anchor('news', 'Back'); ?>