<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('User', 'user'); ?>

			<div class="input">
				<?php echo Form::input('user', Input::post('user', isset($user_center) ? $user_center->user : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Center', 'center'); ?>

			<div class="input">
				<?php echo Form::input('center', Input::post('center', isset($user_center) ? $user_center->center : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>