<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Referral id', 'referral_id'); ?>

			<div class="input">
				<?php echo Form::input('referral_id', Input::post('referral_id', isset($survey_lead_log) ? $survey_lead_log->referral_id : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Batch id', 'batch_id'); ?>

			<div class="input">
				<?php echo Form::input('batch_id', Input::post('batch_id', isset($survey_lead_log) ? $survey_lead_log->batch_id : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>