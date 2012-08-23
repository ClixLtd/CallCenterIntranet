<h2>Listing News</h2>
<br>
<?php if ($news): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Title</th>
			<th>Article</th>
			<th>Call center id</th>
			<th>User id</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($news as $news): ?>		<tr>

			<td><?php echo $news->title; ?></td>
			<td><?php echo $news->article; ?></td>
			<td><?php echo $news->call_center_id; ?></td>
			<td><?php echo $news->user_id; ?></td>
			<td>
				<?php echo Html::anchor('news/view/'.$news->id, 'View'); ?> |
				<?php echo Html::anchor('news/edit/'.$news->id, 'Edit'); ?> |
				<?php echo Html::anchor('news/delete/'.$news->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No News.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('news/create', 'Add new News', array('class' => 'btn success')); ?>

</p>
