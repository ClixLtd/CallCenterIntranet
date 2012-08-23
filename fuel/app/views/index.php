<h2>Listing S</h2>
<br>
<?php if ($s): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($s as $): ?>		<tr>

			<td>
				<?php echo Html::anchor('/view/'.$->id, 'View'); ?> |
				<?php echo Html::anchor('/edit/'.$->id, 'Edit'); ?> |
				<?php echo Html::anchor('/delete/'.$->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No S.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('/create', 'Add new ', array('class' => 'btn success')); ?>

</p>
