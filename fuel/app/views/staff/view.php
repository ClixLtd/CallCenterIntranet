<h2>Viewing #<?php echo $staff->id; ?></h2>

<p>
	<strong>First name:</strong>
	<?php echo $staff->first_name; ?></p>
<p>
	<strong>Last name:</strong>
	<?php echo $staff->last_name; ?></p>
<p>
	<strong>Intranet id:</strong>
	<?php echo $staff->intranet_id; ?></p>
<p>
	<strong>Dialler id:</strong>
	<?php echo $staff->dialler_id; ?></p>
<p>
	<strong>Debtsolv id:</strong>
	<?php echo $staff->debtsolv_id; ?></p>
<p>
	<strong>Network id:</strong>
	<?php echo $staff->network_id; ?></p>
<p>
	<strong>Active:</strong>
	<?php echo $staff->active; ?></p>

<?php echo Html::anchor('staff/edit/'.$staff->id, 'Edit'); ?> |
<?php echo Html::anchor('staff', 'Back'); ?>