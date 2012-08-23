<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($database_query) ? $database_query->title : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Description', 'description'); ?>

			<div class="input">
				<?php echo Form::textarea('description', Input::post('description', isset($database_query) ? $database_query->description : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Query', 'query'); ?>

			<div class="input">
				<?php echo Form::textarea('query', Input::post('query', isset($database_query) ? $database_query->query : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Cache Time (Seconds)', 'cache_time'); ?>

			<div class="input">
				<?php echo Form::input('cache_time', Input::post('cache_time', isset($database_query) ? $database_query->cache_time : '600'), array('class' => 'span6')); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Database Server', 'database_server_id'); ?>

			<div class="input">
				<?php echo Form::select('database_server_id', Input::post('database_server_id', isset($database_query) ? $database_query->database_server_id : isset($server_id) ? $server_id : 'none'), $database_servers); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Database', 'database'); ?>

			<div class="input">
				<?php echo Form::input('database', Input::post('database', isset($database_query) ? $database_query->database : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Username', 'username'); ?>

			<div class="input">
				<?php echo Form::input('username', Input::post('username', isset($database_query) ? $database_query->username : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Password', 'password'); ?>

			<div class="input">
				<?php echo Form::input('password', Input::post('password', isset($database_query) ? $database_query->password : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>