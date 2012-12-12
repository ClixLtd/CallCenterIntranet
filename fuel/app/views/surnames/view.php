<h2>Viewing #<?php echo $surname->id; ?></h2>

<p>
	<strong>Surname:</strong>
	<?php echo $surname->surname; ?></p>
<p>
	<strong>Completed:</strong>
	<?php echo $surname->completed; ?></p>

<?php echo Html::anchor('surnames/edit/'.$surname->id, 'Edit'); ?> |
<?php echo Html::anchor('surnames', 'Back'); ?>