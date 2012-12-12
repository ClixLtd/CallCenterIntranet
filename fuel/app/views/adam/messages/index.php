<h2>Listing Adam_messages</h2>
<br>
<?php if ($adam_messages): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Message</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($adam_messages as $adam_message): ?>		<tr>

			<td><?php echo $adam_message->message; ?></td>
			<td>
				<?php echo Html::anchor('adam/messages/view/'.$adam_message->id, 'View'); ?> |
				<?php echo Html::anchor('adam/messages/edit/'.$adam_message->id, 'Edit'); ?> |
				<?php echo Html::anchor('adam/messages/delete/'.$adam_message->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Adam_messages.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('adam/messages/create', 'Add new Adam message', array('class' => 'btn success')); ?>

</p>
