<h2>Listing Survey_question_answers</h2>
<br>
<?php if ($survey_question_answers): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Question id</th>
			<th>Answer</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($survey_question_answers as $survey_question_answer): ?>		<tr>

			<td><?php echo $survey_question_answer->question_id; ?></td>
			<td><?php echo $survey_question_answer->answer; ?></td>
			<td>
				<?php echo Html::anchor('survey/question/answer/view/'.$survey_question_answer->id, 'View'); ?> |
				<?php echo Html::anchor('survey/question/answer/edit/'.$survey_question_answer->id, 'Edit'); ?> |
				<?php echo Html::anchor('survey/question/answer/delete/'.$survey_question_answer->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Survey_question_answers.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('survey/question/answer/create', 'Add new Survey question answer', array('class' => 'btn btn-success')); ?>

</p>
