<h2>Viewing #<?php echo $staff_department->id; ?></h2>

<p>
	<strong>Title:</strong>
	<?php echo $staff_department->title; ?></p>

<?php echo Html::anchor('staff/department/edit/'.$staff_department->id, 'Edit'); ?> |
<?php echo Html::anchor('staff/department', 'Back'); ?>