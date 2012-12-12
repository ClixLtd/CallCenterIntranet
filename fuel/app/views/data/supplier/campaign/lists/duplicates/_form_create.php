<?php echo Form::open(array('class' => 'form-stacked', 'enctype' => 'multipart/form-data')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('List id', 'list_id'); ?>

			<div class="input">
				<?php echo Form::input('list_id', Input::post('list_id', isset($data_supplier_campaign_lists_duplicate) ? $data_supplier_campaign_lists_duplicate->list_id : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Database server id', 'database_server_id'); ?>

			<div class="input">
				<?php echo Form::input('database_server_id', Input::post('database_server_id', isset($data_supplier_campaign_lists_duplicate) ? $data_supplier_campaign_lists_duplicate->database_server_id : ''), array('class' => 'span6')); ?>

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