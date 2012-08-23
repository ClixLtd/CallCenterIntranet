<h2>Listing Help_topics</h2>
<br>
<?php if ($help_topics): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Title</th>
			<th>Description</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($help_topics as $help_topic): ?>		<tr>

			<td><?php echo $help_topic->title; ?></td>
			<td><?php echo $help_topic->description; ?></td>
			<td>
				<?php echo Html::anchor('help/topic/view/'.$help_topic->id, 'View'); ?> |
				<?php echo Html::anchor('help/topic/edit/'.$help_topic->id, 'Edit'); ?> |
				<?php echo Html::anchor('help/topic/delete/'.$help_topic->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Help_topics.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('help/topic/create', 'Add new Help topic', array('class' => 'btn success')); ?>

</p>
