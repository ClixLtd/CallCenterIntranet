<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Campaign', 'campaign'); ?>

			<div class="input">
				<?php echo Form::input('campaign', Input::post('campaign', isset($adam_announcement) ? $adam_announcement->campaign : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Alert type', 'alert_type'); ?>

			<div class="input">
				<?php echo Form::input('alert_type', Input::post('alert_type', isset($adam_announcement) ? $adam_announcement->alert_type : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Remove date', 'remove_date'); ?>

			<div class="input">
				<?php echo Form::input('remove_date', Input::post('remove_date', isset($adam_announcement) ? $adam_announcement->remove_date : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>