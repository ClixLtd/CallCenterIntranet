<h2>Listing Surnames</h2>
<br>
<?php if ($surnames): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Surname</th>
			<th>Completed</th>
			<th>Last Town</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($surnames as $surname): ?>		<tr>

			<td><?php echo $surname->surname; ?></td>
			<td><?php echo $surname->completed; ?></td>
			<td><?php echo $surname->last_town; ?></td>
			<td>
				<?php echo Html::anchor('surnames/view/'.$surname->id, 'View'); ?> |
				<?php echo Html::anchor('surnames/edit/'.$surname->id, 'Edit'); ?> |
				<?php echo Html::anchor('surnames/delete/'.$surname->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Surnames.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('surnames/create', 'Add new Surname', array('class' => 'btn success')); ?>

</p>
