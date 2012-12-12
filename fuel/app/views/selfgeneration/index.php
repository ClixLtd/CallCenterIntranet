<h2>Listing Selfgenerations</h2>
<br>
<?php if ($selfgenerations): ?>
<table class="zebra-striped datatable">
	<thead>
		<tr>
			<th>Fname</th>
			<th>Sname</th>
			<th>Add1</th>
			<th>Add2</th>
			<th>Postcode</th>
			<th>Telephone</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($selfgenerations as $selfgeneration): ?>		<tr>

			<td><?php echo $selfgeneration->fname; ?></td>
			<td><?php echo $selfgeneration->sname; ?></td>
			<td><?php echo $selfgeneration->add1; ?></td>
			<td><?php echo $selfgeneration->add2; ?></td>
			<td><?php echo $selfgeneration->postcode; ?></td>
			<td><?php echo $selfgeneration->telephone; ?></td>
			<td>
				<?php echo Html::anchor('selfgeneration/view/'.$selfgeneration->id, 'View'); ?> |
				<?php echo Html::anchor('selfgeneration/edit/'.$selfgeneration->id, 'Edit'); ?> |
				<?php echo Html::anchor('selfgeneration/delete/'.$selfgeneration->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Selfgenerations.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('selfgeneration/create', 'Add new Selfgeneration', array('class' => 'btn success')); ?>

</p>
