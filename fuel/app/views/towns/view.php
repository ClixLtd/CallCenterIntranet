<h2>Viewing #<?php echo $town->id; ?></h2>

<p>
	<strong>Town:</strong>
	<?php echo $town->town; ?></p>

<?php echo Html::anchor('towns/edit/'.$town->id, 'Edit'); ?> |
<?php echo Html::anchor('towns', 'Back'); ?>