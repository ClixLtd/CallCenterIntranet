<h2>Editing Adam_announcement</h2>
<br>

<?php echo render('adam/announcements/_form'); ?>
<p>
	<?php echo Html::anchor('adam/announcements/view/'.$adam_announcement->id, 'View'); ?> |
	<?php echo Html::anchor('adam/announcements', 'Back'); ?></p>
