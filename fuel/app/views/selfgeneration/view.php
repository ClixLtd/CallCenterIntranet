<h2>Viewing #<?php echo $selfgeneration->id; ?></h2>

<p>
	<strong>Fname:</strong>
	<?php echo $selfgeneration->fname; ?></p>
<p>
	<strong>Sname:</strong>
	<?php echo $selfgeneration->sname; ?></p>
<p>
	<strong>Add1:</strong>
	<?php echo $selfgeneration->add1; ?></p>
<p>
	<strong>Add2:</strong>
	<?php echo $selfgeneration->add2; ?></p>
<p>
	<strong>Postcode:</strong>
	<?php echo $selfgeneration->postcode; ?></p>
<p>
	<strong>Telephone:</strong>
	<?php echo $selfgeneration->telephone; ?></p>

<?php echo Html::anchor('selfgeneration/edit/'.$selfgeneration->id, 'Edit'); ?> |
<?php echo Html::anchor('selfgeneration', 'Back'); ?>