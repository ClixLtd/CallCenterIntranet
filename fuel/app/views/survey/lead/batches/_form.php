<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Supplier id', 'supplier_id'); ?>

			<div class="input">
				<?php echo Form::input('supplier_id', Input::post('supplier_id', isset($survey_lead_batch) ? $survey_lead_batch->supplier_id : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Date added', 'date_added'); ?>

			<div class="input">
				<?php echo Form::input('date_added', Input::post('date_added', isset($survey_lead_batch) ? $survey_lead_batch->date_added : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Filename', 'filename'); ?>

			<div class="input">
				<?php echo Form::input('filename', Input::post('filename', isset($survey_lead_batch) ? $survey_lead_batch->filename : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Collected', 'collected'); ?>

			<div class="input">
				<?php echo Form::input('collected', Input::post('collected', isset($survey_lead_batch) ? $survey_lead_batch->collected : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Date collected', 'date_collected'); ?>

			<div class="input">
				<?php echo Form::input('date_collected', Input::post('date_collected', isset($survey_lead_batch) ? $survey_lead_batch->date_collected : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>