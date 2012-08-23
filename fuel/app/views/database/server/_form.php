<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($database_server) ? $database_server->title : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Hostname', 'hostname'); ?>

			<div class="input">
				<?php echo Form::input('hostname', Input::post('hostname', isset($database_server) ? $database_server->hostname : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Port', 'port'); ?>

			<div class="input">
				<?php echo Form::input('port', Input::post('port', isset($database_server) ? $database_server->port : '3306'), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Type', 'type'); ?>

			<div class="input">
				<?php echo Form::input('type', Input::post('type', isset($database_server) ? $database_server->type : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Username', 'username'); ?>

			<div class="input">
				<?php echo Form::input('username', Input::post('username', isset($database_server) ? $database_server->username : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Password', 'password'); ?>

			<div class="input">
				<?php echo Form::input('password', Input::post('password', isset($database_server) ? $database_server->password : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>