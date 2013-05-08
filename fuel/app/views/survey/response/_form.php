<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Reference', 'reference'); ?>

			<div class="input">
				<?php echo Form::input('reference', Input::post('reference', isset($survey_response) ? $survey_response->reference : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Question id', 'question_id'); ?>

			<div class="input">
				<?php echo Form::input('question_id', Input::post('question_id', isset($survey_response) ? $survey_response->question_id : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Answer id', 'answer_id'); ?>

			<div class="input">
				<?php echo Form::input('answer_id', Input::post('answer_id', isset($survey_response) ? $survey_response->answer_id : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Extra', 'extra'); ?>

			<div class="input">
				<?php echo Form::textarea('extra', Input::post('extra', isset($survey_response) ? $survey_response->extra : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>