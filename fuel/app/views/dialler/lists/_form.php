<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('List name', 'list_name'); ?>

			<div class="input">
				<?php echo Form::input('list_name', Input::post('list_name', isset($dialler_list) ? $dialler_list->list_name : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('List description', 'list_description'); ?>

			<div class="input">
				<?php echo Form::input('list_description', Input::post('list_description', isset($dialler_list) ? $dialler_list->list_description : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>