<h2>Listing Survey_questions</h2>
<br>
<?php if ($survey_questions): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Survey id</th>
			<th>Question</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($survey_questions as $survey_question): ?>		<tr>

			<td><?php echo $survey_question->survey_id; ?></td>
			<td><?php echo $survey_question->question; ?></td>
			<td>
				<?php echo Html::anchor('survey/question/view/'.$survey_question->id, 'View'); ?> |
				<?php echo Html::anchor('survey/question/edit/'.$survey_question->id, 'Edit'); ?> |
				<?php echo Html::anchor('survey/question/delete/'.$survey_question->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Survey_questions.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('survey/question/create', 'Add new Survey question', array('class' => 'btn btn-success')); ?>

</p>
