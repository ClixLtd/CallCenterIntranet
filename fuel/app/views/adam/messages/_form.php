<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Message', 'message'); ?>

			<div class="input">
				<?php echo Form::textarea('message', Input::post('message', isset($adam_message) ? $adam_message->message : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>