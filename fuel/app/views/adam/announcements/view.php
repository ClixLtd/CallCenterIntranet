<h2>Viewing #<?php echo $adam_announcement->id; ?></h2>

<p>
	<strong>Campaign:</strong>
	<?php echo $adam_announcement->campaign; ?></p>
<p>
	<strong>Alert type:</strong>
	<?php echo $adam_announcement->alert_type; ?></p>
<p>
	<strong>Remove date:</strong>
	<?php echo $adam_announcement->remove_date; ?></p>

<?php echo Html::anchor('adam/announcements/edit/'.$adam_announcement->id, 'Edit'); ?> |
<?php echo Html::anchor('adam/announcements', 'Back'); ?>