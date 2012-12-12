<h2>Viewing #<?php echo $lead_table->id; ?></h2>

<p>
	<strong>Phone number:</strong>
	<?php echo $lead_table->phone_number; ?></p>
<p>
	<strong>Title:</strong>
	<?php echo $lead_table->title; ?></p>
<p>
	<strong>First name:</strong>
	<?php echo $lead_table->first_name; ?></p>
<p>
	<strong>Middle initial:</strong>
	<?php echo $lead_table->middle_initial; ?></p>
<p>
	<strong>Last name:</strong>
	<?php echo $lead_table->last_name; ?></p>
<p>
	<strong>Address1:</strong>
	<?php echo $lead_table->address1; ?></p>
<p>
	<strong>Address2:</strong>
	<?php echo $lead_table->address2; ?></p>
<p>
	<strong>Address3:</strong>
	<?php echo $lead_table->address3; ?></p>
<p>
	<strong>City:</strong>
	<?php echo $lead_table->city; ?></p>
<p>
	<strong>State:</strong>
	<?php echo $lead_table->state; ?></p>
<p>
	<strong>Province:</strong>
	<?php echo $lead_table->province; ?></p>
<p>
	<strong>Postal code:</strong>
	<?php echo $lead_table->postal_code; ?></p>
<p>
	<strong>Country code:</strong>
	<?php echo $lead_table->country_code; ?></p>
<p>
	<strong>Gender:</strong>
	<?php echo $lead_table->gender; ?></p>
<p>
	<strong>Date of birth:</strong>
	<?php echo $lead_table->date_of_birth; ?></p>
<p>
	<strong>Alt phone:</strong>
	<?php echo $lead_table->alt_phone; ?></p>
<p>
	<strong>Email:</strong>
	<?php echo $lead_table->email; ?></p>
<p>
	<strong>Security phrase:</strong>
	<?php echo $lead_table->security_phrase; ?></p>
<p>
	<strong>Comments:</strong>
	<?php echo $lead_table->comments; ?></p>

<?php echo Html::anchor('lead/table/edit/'.$lead_table->id, 'Edit'); ?> |
<?php echo Html::anchor('lead/table', 'Back'); ?>