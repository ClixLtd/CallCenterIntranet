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
			<?php echo Form::label('Department', 'department'); ?>

			<div class="input">
    			
    			<select name="department_id">
    			    <?php foreach ($departments AS $department): ?>
    			    <?php 
        			    $staff_department_id = (isset($staff)) ? $staff->department_id : '';
    			    ?>
    			    <option value="<?php echo $department->id; ?>" <?php if ($staff_department_id == $department->id) { echo "SELECTED"; } ?>><?php echo $department->title; ?></option>
    			    <?php endforeach; ?>
    			</select>

			</div>
		</div>
		
		<div class="clearfix">
			<?php echo Form::label('Center', 'center'); ?>

			<div class="input">
    			
    			<select name="center_id">
    			    <?php foreach ($centers AS $center): ?>
    			    <?php 
        			    $staff_center_id = (isset($staff)) ? $staff->center_id : '';
    			    ?>
    			    <option value="<?php echo $center->id; ?>" <?php if ($staff_center_id == $center->id) { echo "SELECTED"; } ?>><?php echo $center->title; ?></option>
    			    <?php endforeach; ?>
    			</select>

			</div>
		</div>
		
		
		
		<div class="clearfix">
			<?php echo Form::label('Active', 'active'); ?>

			<div class="input">
			
			<select name="active">
    			<option value="1" <?php if ($staff->active == 1) { echo "SELECTED"; } ?>>Active</option>
    			<option value="0" <?php if ($staff->active == 0) { echo "SELECTED"; } ?>>Disabled</option>
			</select>
			

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>