<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Database query id', 'database_query_id'); ?>

			<div class="input">
				<?php echo Form::input('database_query_id', Input::post('database_query_id', isset($database_query_tag) ? $database_query_tag->database_query_id : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Tag', 'tag'); ?>

			<div class="input">
				<?php echo Form::input('tag', Input::post('tag', isset($database_query_tag) ? $database_query_tag->tag : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>