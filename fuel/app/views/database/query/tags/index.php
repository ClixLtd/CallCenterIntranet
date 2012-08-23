<h2>Listing Database_query_tags</h2>
<br>
<?php if ($database_query_tags): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Database query id</th>
			<th>Tag</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($database_query_tags as $database_query_tag): ?>		<tr>

			<td><?php echo $database_query_tag->database_query_id; ?></td>
			<td><?php echo $database_query_tag->tag; ?></td>
			<td>
				<?php echo Html::anchor('database/query/tags/view/'.$database_query_tag->id, 'View'); ?> |
				<?php echo Html::anchor('database/query/tags/edit/'.$database_query_tag->id, 'Edit'); ?> |
				<?php echo Html::anchor('database/query/tags/delete/'.$database_query_tag->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Database_query_tags.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('database/query/tags/create', 'Add new Database query tag', array('class' => 'btn success')); ?>

</p>
