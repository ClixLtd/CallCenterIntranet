<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($data_supplier_list) ? $data_supplier_list->title : ''), array('class' => 'span6')); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Data supplier id', 'data_supplier_id'); ?>

			<div class="input">
				<?php echo Form::select('data_supplier_id', Input::post('data_supplier_id', isset($data_supplier_list) ? $data_supplier_list->data_supplier_id :  'none'), $data_suppliers); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Datafile', 'datafile'); ?>

			<div class="input">
				<?php echo Form::textarea('datafile', Input::post('datafile', isset($data_supplier_list) ? $data_supplier_list->datafile : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Cost', 'cost'); ?>

			<div class="input">
				<?php echo Form::input('cost', Input::post('cost', isset($data_supplier_list) ? $data_supplier_list->cost : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Total leads', 'total_leads'); ?>

			<div class="input">
				<?php echo Form::input('total_leads', Input::post('total_leads', isset($data_supplier_list) ? $data_supplier_list->total_leads : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>