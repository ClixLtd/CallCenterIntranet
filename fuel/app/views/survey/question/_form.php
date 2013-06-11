<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Survey id', 'survey_id'); ?>

			<div class="input">
				<?php echo Form::input('survey_id', Input::post('survey_id', isset($survey_question) ? $survey_question->survey_id : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Question', 'question'); ?>

			<div class="input">
				<?php echo Form::textarea('question', Input::post('question', isset($survey_question) ? $survey_question->question : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Order', 'order'); ?>

			<div class="input">
				<?php echo Form::input('order', Input::post('order', isset($survey_question) ? $survey_question->order : ''), array('class' => 'span8')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>