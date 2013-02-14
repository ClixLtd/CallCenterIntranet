<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('First name', 'first_name'); ?>

			<div class="input">
				<?php echo Form::input('first_name', Input::post('first_name', isset($staff) ? $staff->first_name : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Last name', 'last_name'); ?>

			<div class="input">
				<?php echo Form::input('last_name', Input::post('last_name', isset($staff) ? $staff->last_name : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Intranet id', 'intranet_id'); ?>

			<div class="input">
				<?php echo Form::input('intranet_id', Input::post('intranet_id', isset($staff) ? $staff->intranet_id : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Dialler id', 'dialler_id'); ?>

			<div class="input">
				<?php echo Form::input('dialler_id', Input::post('dialler_id', isset($staff) ? $staff->dialler_id : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Debtsolv id', 'debtsolv_id'); ?>

			<div class="input">
				<?php echo Form::input('debtsolv_id', Input::post('debtsolv_id', isset($staff) ? $staff->debtsolv_id : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Network id', 'network_id'); ?>

			<div class="input">
				<?php echo Form::input('network_id', Input::post('network_id', isset($staff) ? $staff->network_id : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Active', 'active'); ?>

			<div class="input">
				<?php echo Form::input('active', Input::post('active', isset($staff) ? $staff->active : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>