<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($help_ticket) ? $help_ticket->title : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Description', 'description'); ?>

			<div class="input">
				<?php echo Form::textarea('description', Input::post('description', isset($help_ticket) ? $help_ticket->description : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Priority', 'priority'); ?>

			<div class="input">
				<?php echo Form::input('priority', Input::post('priority', isset($help_ticket) ? $help_ticket->priority : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Help topic id', 'help_topic_id'); ?>

			<div class="input">
				<?php echo Form::input('help_topic_id', Input::post('help_topic_id', isset($help_ticket) ? $help_ticket->help_topic_id : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('User id', 'user_id'); ?>

			<div class="input">
				<?php echo Form::input('user_id', Input::post('user_id', isset($help_ticket) ? $help_ticket->user_id : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>