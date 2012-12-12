<h2>Listing Towns</h2>
<br>
<?php if ($towns): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Town</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($towns as $town): ?>		<tr>

			<td><?php echo $town->town; ?></td>
			<td>
				<?php echo Html::anchor('towns/view/'.$town->id, 'View'); ?> |
				<?php echo Html::anchor('towns/edit/'.$town->id, 'Edit'); ?> |
				<?php echo Html::anchor('towns/delete/'.$town->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Towns.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('towns/create', 'Add new Town', array('class' => 'btn success')); ?>

</p>
