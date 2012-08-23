<h2><?php echo $query_details->title; ?></h2>

<p>
<?php echo $query_details->description; ?>
</p>

<h3>Results</h3>

<p>
	<b>Total Rows: </b><?php echo count($query_results); ?>
	<?php if (count($query_details->database_query_tags) > 0) { ?>
	<br /><b>Tags : </b>
		<?php foreach($query_details->database_query_tags AS $id => $tag): ?>
			<?php echo Html::anchor('database/query/tag/'.$tag->tag, '<i>'.$tag->tag.'</i>'); 
				if ( count($query_details->database_query_tags) >= ($id+1) ){
					echo ',';
				}
			?>
		<?php endforeach; ?>
	<?php } ?> 
</p>

<table class="zebra-striped datatable">
	<thead>
		<tr>
<?php foreach ($query_columns AS $column): ?>
			<th><?php echo $column; ?></th>
<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
<?php foreach ($query_results as $query_result): ?>
		<tr>
<?php foreach ($query_columns AS $column): ?>
			<td><?php echo $query_result[$column]; ?></td>
<?php endforeach; ?>
		</tr>
<?php endforeach; ?>	</tbody>
</table>
