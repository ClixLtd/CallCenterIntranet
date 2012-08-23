<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Company name', 'company_name'); ?>

			<div class="input">
				<?php echo Form::input('company_name', Input::post('company_name', isset($data_supplier) ? $data_supplier->company_name : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Contact name', 'contact_name'); ?>

			<div class="input">
				<?php echo Form::input('contact_name', Input::post('contact_name', isset($data_supplier) ? $data_supplier->contact_name : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Contact email', 'contact_email'); ?>

			<div class="input">
				<?php echo Form::input('contact_email', Input::post('contact_email', isset($data_supplier) ? $data_supplier->contact_email : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Contact address', 'contact_address'); ?>

			<div class="input">
				<?php echo Form::textarea('contact_address', Input::post('contact_address', isset($data_supplier) ? $data_supplier->contact_address : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Web address', 'web_address'); ?>

			<div class="input">
				<?php echo Form::input('web_address', Input::post('web_address', isset($data_supplier) ? $data_supplier->web_address : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Telephone', 'telephone'); ?>

			<div class="input">
				<?php echo Form::input('telephone', Input::post('telephone', isset($data_supplier) ? $data_supplier->telephone : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Mobile', 'mobile'); ?>

			<div class="input">
				<?php echo Form::input('mobile', Input::post('mobile', isset($data_supplier) ? $data_supplier->mobile : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Fax', 'fax'); ?>

			<div class="input">
				<?php echo Form::input('fax', Input::post('fax', isset($data_supplier) ? $data_supplier->fax : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>