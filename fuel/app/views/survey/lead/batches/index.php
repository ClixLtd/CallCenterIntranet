<h2>Listing Survey_lead_batches</h2>
<br>
<?php if ($survey_lead_batches): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Supplier id</th>
			<th>Date added</th>
			<th>Filename</th>
			<th>Collected</th>
			<th>Date collected</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($survey_lead_batches as $survey_lead_batch): ?>		<tr>

			<td><?php echo $survey_lead_batch->supplier_id; ?></td>
			<td><?php echo $survey_lead_batch->date_added; ?></td>
			<td><?php echo $survey_lead_batch->filename; ?></td>
			<td><?php echo $survey_lead_batch->collected; ?></td>
			<td><?php echo $survey_lead_batch->date_collected; ?></td>
			<td>
				<?php echo Html::anchor('survey/lead/batches/view/'.$survey_lead_batch->id, 'View'); ?> |
				<?php echo Html::anchor('survey/lead/batches/edit/'.$survey_lead_batch->id, 'Edit'); ?> |
				<?php echo Html::anchor('survey/lead/batches/delete/'.$survey_lead_batch->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Survey_lead_batches.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('survey/lead/batches/create', 'Add new Survey lead batch', array('class' => 'btn btn-success')); ?>

</p>
