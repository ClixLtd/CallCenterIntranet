<h2>Listing Database_queries</h2>
<br>
<?php if ($database_queries): ?>
<table class="zebra-striped datatable">
	<thead>
		<tr>
			<th>Title</th>
			<th>Description</th>
			<th>Server</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($database_queries as $database_query): ?>		<tr>

			<td><?php echo $database_query->title; ?></td>
			<td><?php echo $database_query->description; ?>
			<?php if (count($database_query->database_query_tags) > 0) { ?>
			<br /><b><i>Tags : </i></b>
				<?php foreach($database_query->database_query_tags AS $id => $tag): ?>
					<?php echo Html::anchor('database/query/tag/'.$tag->tag, '<i>'.$tag->tag.'</i>'); 
						if ( count($database_query->database_query_tags) >= ($id+1) ){
							echo ',';
						}
					?>
				<?php endforeach; ?>
			<?php } ?> 
			</td>
			<td><?php echo $database_query->database_servers->title; ?></td>
			<td>
				<?php echo Html::anchor('database/query/run/'.$database_query->id, 'Run'); ?> |
				<?php echo Html::anchor('database/query/run/'.$database_query->id.'/json', 'JSON'); ?> |
				<?php echo Html::anchor('database/query/view/'.$database_query->id, 'View'); ?> |
				<?php echo Html::anchor('database/query/edit/'.$database_query->id, 'Edit'); ?> |
				<?php echo Html::anchor('database/query/delete/'.$database_query->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Database_queries.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('database/query/create'.(isset($server_id) ? '/'.$server_id : ''), 'Add new Database query', array('class' => 'btn success')); ?>

</p>
