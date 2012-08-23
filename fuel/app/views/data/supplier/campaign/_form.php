<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Data supplier id', 'data_supplier_id'); ?>

			<div class="input">
				<?php echo Form::input('data_supplier_id', Input::post('data_supplier_id', isset($data_supplier_campaign) ? $data_supplier_campaign->data_supplier_id : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($data_supplier_campaign) ? $data_supplier_campaign->title : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Description', 'description'); ?>

			<div class="input">
				<?php echo Form::textarea('description', Input::post('description', isset($data_supplier_campaign) ? $data_supplier_campaign->description : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>