<h2>Listing Survey_lead_suppliers</h2>
<br>
<?php if ($survey_lead_suppliers): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>Key</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($survey_lead_suppliers as $survey_lead_supplier): ?>		<tr>

			<td><?php echo $survey_lead_supplier->name; ?></td>
			<td><?php echo $survey_lead_supplier->email; ?></td>
			<td><?php echo $survey_lead_supplier->key; ?></td>
			<td>
				<?php echo Html::anchor('survey/lead/suppliers/view/'.$survey_lead_supplier->id, 'View'); ?> |
				<?php echo Html::anchor('survey/lead/suppliers/edit/'.$survey_lead_supplier->id, 'Edit'); ?> |
				<?php echo Html::anchor('survey/lead/suppliers/delete/'.$survey_lead_supplier->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Survey_lead_suppliers.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('survey/lead/suppliers/create', 'Add new Survey lead supplier', array('class' => 'btn btn-success')); ?>

</p>
