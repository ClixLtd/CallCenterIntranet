<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Surname', 'surname'); ?>

			<div class="input">
				<?php echo Form::input('surname', Input::post('surname', isset($surname) ? $surname->surname : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Completed', 'completed'); ?>

			<div class="input">
				<?php echo Form::input('completed', Input::post('completed', isset($surname) ? $surname->completed : '0'), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Last Town', 'last_town'); ?>

			<div class="input">
				<?php echo Form::input('last_town', Input::post('last_town', isset($surname) ? $surname->last_town : '0'), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>