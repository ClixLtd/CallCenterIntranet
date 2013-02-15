<h2>Editing Staff_department</h2>
<br>

<?php echo render('staff/department/_form'); ?>
<p>
	<?php echo Html::anchor('staff/department/view/'.$staff_department->id, 'View'); ?> |
	<?php echo Html::anchor('staff/department', 'Back'); ?></p>
