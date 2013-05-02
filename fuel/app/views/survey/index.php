<h2>Listing Surveys</h2>
<br>
<?php if ($surveys): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Title</th>
			<th>Description</th>
			<th>Type</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($surveys as $survey): ?>		<tr>

			<td><?php echo $survey->title; ?></td>
			<td><?php echo $survey->description; ?></td>
			<td><?php echo $survey->type; ?></td>
			<td>
				<?php echo Html::anchor('survey/view/'.$survey->id, 'View'); ?> |
				<?php echo Html::anchor('survey/edit/'.$survey->id, 'Edit'); ?> |
				<?php echo Html::anchor('survey/delete/'.$survey->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Surveys.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('survey/create', 'Add new Survey', array('class' => 'btn btn-success')); ?>

</p>
