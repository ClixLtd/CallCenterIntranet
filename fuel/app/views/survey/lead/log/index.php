<h2>Listing Survey_lead_logs</h2>
<br>
<?php if ($survey_lead_logs): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Referral id</th>
			<th>Batch id</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($survey_lead_logs as $survey_lead_log): ?>		<tr>

			<td><?php echo $survey_lead_log->referral_id; ?></td>
			<td><?php echo $survey_lead_log->batch_id; ?></td>
			<td>
				<?php echo Html::anchor('survey/lead/log/view/'.$survey_lead_log->id, 'View'); ?> |
				<?php echo Html::anchor('survey/lead/log/edit/'.$survey_lead_log->id, 'Edit'); ?> |
				<?php echo Html::anchor('survey/lead/log/delete/'.$survey_lead_log->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Survey_lead_logs.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('survey/lead/log/create', 'Add new Survey lead log', array('class' => 'btn btn-success')); ?>

</p>
