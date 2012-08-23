<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Campaign title', 'campaign_title'); ?>

			<div class="input">
				<?php echo Form::input('campaign_title', Input::post('campaign_title', isset($dialler_campaign) ? $dialler_campaign->campaign_title : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Campaign name', 'campaign_name'); ?>

			<div class="input">
				<?php echo Form::input('campaign_name', Input::post('campaign_name', isset($dialler_campaign) ? $dialler_campaign->campaign_name : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Campaign description', 'campaign_description'); ?>

			<div class="input">
				<?php echo Form::input('campaign_description', Input::post('campaign_description', isset($dialler_campaign) ? $dialler_campaign->campaign_description : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Call center id', 'call_center_id'); ?>

			<div class="input">
				
				<?php echo Form::select('call_center_id', Input::post('call_center_id', isset($dialler_campaign) ? $dialler_campaign->call_center_id : 'none'), $call_centers); ?>
				
			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>