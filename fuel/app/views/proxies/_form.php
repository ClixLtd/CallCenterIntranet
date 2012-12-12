<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Host', 'host'); ?>

			<div class="input">
				<?php echo Form::input('host', Input::post('host', isset($proxy) ? $proxy->host : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Port', 'port'); ?>

			<div class="input">
				<?php echo Form::input('port', Input::post('port', isset($proxy) ? $proxy->port : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Fail count', 'fail_count'); ?>

			<div class="input">
				<?php echo Form::input('fail_count', Input::post('fail_count', isset($proxy) ? $proxy->fail_count : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>