<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Question id', 'question_id'); ?>

			<div class="input">
				<?php echo Form::input('question_id', Input::post('question_id', isset($survey_question_answer) ? $survey_question_answer->question_id : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Answer', 'answer'); ?>

			<div class="input">
				<?php echo Form::textarea('answer', Input::post('answer', isset($survey_question_answer) ? $survey_question_answer->answer : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>