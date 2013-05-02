<h2>Listing Survey_responses</h2>
<br>
<?php if ($survey_responses): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Reference</th>
			<th>Question id</th>
			<th>Answer id</th>
			<th>Extra</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($survey_responses as $survey_response): ?>		<tr>

			<td><?php echo $survey_response->reference; ?></td>
			<td><?php echo $survey_response->question_id; ?></td>
			<td><?php echo $survey_response->answer_id; ?></td>
			<td><?php echo $survey_response->extra; ?></td>
			<td>
				<?php echo Html::anchor('survey/response/view/'.$survey_response->id, 'View'); ?> |
				<?php echo Html::anchor('survey/response/edit/'.$survey_response->id, 'Edit'); ?> |
				<?php echo Html::anchor('survey/response/delete/'.$survey_response->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Survey_responses.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('survey/response/create', 'Add new Survey response', array('class' => 'btn btn-success')); ?>

</p>
