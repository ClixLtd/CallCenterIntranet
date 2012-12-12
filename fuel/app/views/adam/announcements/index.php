<h2>Listing Adam_announcements</h2>
<br>
<?php if ($adam_announcements): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Campaign</th>
			<th>Alert type</th>
			<th>Remove date</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($adam_announcements as $adam_announcement): ?>		<tr>

			<td><?php echo $adam_announcement->campaign; ?></td>
			<td><?php echo $adam_announcement->alert_type; ?></td>
			<td><?php echo $adam_announcement->remove_date; ?></td>
			<td>
				<?php echo Html::anchor('adam/announcements/view/'.$adam_announcement->id, 'View'); ?> |
				<?php echo Html::anchor('adam/announcements/edit/'.$adam_announcement->id, 'Edit'); ?> |
				<?php echo Html::anchor('adam/announcements/delete/'.$adam_announcement->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Adam_announcements.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('adam/announcements/create', 'Add new Adam announcement', array('class' => 'btn success')); ?>

</p>
