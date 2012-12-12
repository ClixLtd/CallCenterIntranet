<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Fname', 'fname'); ?>

			<div class="input">
				<?php echo Form::input('fname', Input::post('fname', isset($selfgeneration) ? $selfgeneration->fname : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Sname', 'sname'); ?>

			<div class="input">
				<?php echo Form::input('sname', Input::post('sname', isset($selfgeneration) ? $selfgeneration->sname : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Add1', 'add1'); ?>

			<div class="input">
				<?php echo Form::input('add1', Input::post('add1', isset($selfgeneration) ? $selfgeneration->add1 : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Add2', 'add2'); ?>

			<div class="input">
				<?php echo Form::input('add2', Input::post('add2', isset($selfgeneration) ? $selfgeneration->add2 : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Postcode', 'postcode'); ?>

			<div class="input">
				<?php echo Form::input('postcode', Input::post('postcode', isset($selfgeneration) ? $selfgeneration->postcode : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Telephone', 'telephone'); ?>

			<div class="input">
				<?php echo Form::input('telephone', Input::post('telephone', isset($selfgeneration) ? $selfgeneration->telephone : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>