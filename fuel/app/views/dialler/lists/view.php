<h2>Viewing #<?php echo $dialler_list->id; ?></h2>

<p>
	<strong>List name:</strong>
	<?php echo $dialler_list->list_name; ?></p>
<p>
	<strong>List description:</strong>
	<?php echo $dialler_list->list_description; ?></p>

<?php echo Html::anchor('dialler/lists/edit/'.$dialler_list->id, 'Edit'); ?> |
<?php echo Html::anchor('dialler/lists', 'Back'); ?>