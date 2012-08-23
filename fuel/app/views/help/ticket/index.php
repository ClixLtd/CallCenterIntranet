<h2>Listing Help_tickets</h2>
<br>
<?php if ($help_tickets): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Title</th>
			<th>Description</th>
			<th>Priority</th>
			<th>Help topic id</th>
			<th>User id</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($help_tickets as $help_ticket): ?>		<tr>

			<td><?php echo $help_ticket->title; ?></td>
			<td><?php echo $help_ticket->description; ?></td>
			<td><?php echo $help_ticket->priority; ?></td>
			<td><?php echo $help_ticket->help_topic_id; ?></td>
			<td><?php echo $help_ticket->user_id; ?></td>
			<td>
				<?php echo Html::anchor('help/ticket/view/'.$help_ticket->id, 'View'); ?> |
				<?php echo Html::anchor('help/ticket/edit/'.$help_ticket->id, 'Edit'); ?> |
				<?php echo Html::anchor('help/ticket/delete/'.$help_ticket->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Help_tickets.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('help/ticket/create', 'Add new Help ticket', array('class' => 'btn success')); ?>

</p>
