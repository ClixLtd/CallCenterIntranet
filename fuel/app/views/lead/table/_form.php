<?php echo Form::open(array('class' => 'form-stacked', 'enctype' => 'multipart/form-data')); ?>

	<fieldset>
	
		<div class="clearfix">
			<?php echo Form::label('List ID', 'list_id'); ?>

			<div class="input">
				<?php echo Form::input('list_id', Input::post('list_id', isset($list_id) ? $list_id : ''), array('class' => 'span6')); ?>

			</div>
		</div>

	
		<div class="clearfix">
			<?php echo Form::label('Duplicate numbers', 'duplicate_number'); ?>

			<div class="input">
				<?php echo Form::file('duplicate_numbers', array('class' => 'span6')); ?>

			</div>
		</div>

		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>