<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($call_center) ? $call_center->title : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Short Code', 'shortcode'); ?>

			<div class="input">
				<?php echo Form::input('shortcode', Input::post('shortcode', isset($call_center) ? $call_center->shortcode : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Address', 'address'); ?>

			<div class="input">
				<?php echo Form::textarea('address', Input::post('address', isset($call_center) ? $call_center->address : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Phone number', 'phone_number'); ?>

			<div class="input">
				<?php echo Form::input('phone_number', Input::post('phone_number', isset($call_center) ? $call_center->phone_number : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>