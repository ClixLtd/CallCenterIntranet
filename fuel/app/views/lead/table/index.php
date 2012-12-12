<h2>Listing Lead_tables</h2>
<br>
<?php if ($lead_tables): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Phone number</th>
			<th>Title</th>
			<th>First name</th>
			<th>Middle initial</th>
			<th>Last name</th>
			<th>Address1</th>
			<th>Address2</th>
			<th>Address3</th>
			<th>City</th>
			<th>State</th>
			<th>Province</th>
			<th>Postal code</th>
			<th>Country code</th>
			<th>Gender</th>
			<th>Date of birth</th>
			<th>Alt phone</th>
			<th>Email</th>
			<th>Security phrase</th>
			<th>Comments</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($lead_tables as $lead_table): ?>		<tr>

			<td><?php echo $lead_table->phone_number; ?></td>
			<td><?php echo $lead_table->title; ?></td>
			<td><?php echo $lead_table->first_name; ?></td>
			<td><?php echo $lead_table->middle_initial; ?></td>
			<td><?php echo $lead_table->last_name; ?></td>
			<td><?php echo $lead_table->address1; ?></td>
			<td><?php echo $lead_table->address2; ?></td>
			<td><?php echo $lead_table->address3; ?></td>
			<td><?php echo $lead_table->city; ?></td>
			<td><?php echo $lead_table->state; ?></td>
			<td><?php echo $lead_table->province; ?></td>
			<td><?php echo $lead_table->postal_code; ?></td>
			<td><?php echo $lead_table->country_code; ?></td>
			<td><?php echo $lead_table->gender; ?></td>
			<td><?php echo $lead_table->date_of_birth; ?></td>
			<td><?php echo $lead_table->alt_phone; ?></td>
			<td><?php echo $lead_table->email; ?></td>
			<td><?php echo $lead_table->security_phrase; ?></td>
			<td><?php echo $lead_table->comments; ?></td>
			<td>
				<?php echo Html::anchor('lead/table/view/'.$lead_table->id, 'View'); ?> |
				<?php echo Html::anchor('lead/table/edit/'.$lead_table->id, 'Edit'); ?> |
				<?php echo Html::anchor('lead/table/delete/'.$lead_table->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Lead_tables.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('lead/table/create', 'Add new Lead table', array('class' => 'btn success')); ?>

</p>
