<h2>Viewing #<?php echo $dialler_campaign->id; ?></h2>

<p>
	<strong>Campaign title:</strong>
	<?php echo $dialler_campaign->campaign_title; ?></p>
<p>
	<strong>Campaign name:</strong>
	<?php echo $dialler_campaign->campaign_name; ?></p>
<p>
	<strong>Campaign description:</strong>
	<?php echo $dialler_campaign->campaign_description; ?></p>
<p>
	<strong>Call center id:</strong>
	<?php echo $dialler_campaign->call_center_id; ?></p>

<?php echo Html::anchor('dialler/campaign/edit/'.$dialler_campaign->id, 'Edit'); ?> |
<?php echo Html::anchor('dialler/campaign', 'Back'); ?>