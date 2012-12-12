<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Id', 'id'); ?>

			<div class="input">
				<?php echo Form::input('id', Input::post('id', isset($api_user) ? $api_user->id : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Key', 'key'); ?>

			<div class="input">
				<?php echo Form::input('key', Input::post('key', isset($api_user) ? $api_user->key : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Status', 'status'); ?>

			<div class="input">
				<?php echo Form::input('status', Input::post('status', isset($api_user) ? $api_user->status : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Description', 'description'); ?>

			<div class="input">
				<?php echo Form::input('description', Input::post('description', isset($api_user) ? $api_user->description : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Ip', 'ip'); ?>

			<div class="input">
				<?php echo Form::input('ip', Input::post('ip', isset($api_user) ? $api_user->ip : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>