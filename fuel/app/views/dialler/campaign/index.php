<h2>Listing Dialler_campaigns</h2>
<br>
<?php if ($dialler_campaigns): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Campaign title</th>
			<th>Campaign name</th>
			<th>Campaign description</th>
			<th>Call center id</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($dialler_campaigns as $dialler_campaign): ?>		<tr>

			<td><?php echo $dialler_campaign->campaign_title; ?></td>
			<td><?php echo $dialler_campaign->campaign_name; ?></td>
			<td><?php echo $dialler_campaign->campaign_description; ?></td>
			<td><?php echo $dialler_campaign->call_center_id; ?></td>
			<td>
				<?php echo Html::anchor('dialler/campaign/view/'.$dialler_campaign->id, 'View'); ?> |
				<?php echo Html::anchor('dialler/campaign/edit/'.$dialler_campaign->id, 'Edit'); ?> |
				<?php echo Html::anchor('dialler/campaign/delete/'.$dialler_campaign->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Dialler_campaigns.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('dialler/campaign/create', 'Add new Dialler campaign', array('class' => 'btn success')); ?>

</p>
