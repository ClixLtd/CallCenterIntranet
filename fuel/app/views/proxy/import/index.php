<h2>Listing Proxy_imports</h2>
<br>
<?php if ($proxy_imports): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($proxy_imports as $proxy_import): ?>		<tr>

			<td><?php echo $proxy_import->name; ?></td>
			<td>
				<?php echo Html::anchor('proxy/import/view/'.$proxy_import->id, 'View'); ?> |
				<?php echo Html::anchor('proxy/import/edit/'.$proxy_import->id, 'Edit'); ?> |
				<?php echo Html::anchor('proxy/import/delete/'.$proxy_import->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Proxy_imports.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('proxy/import/create', 'Add new Proxy import', array('class' => 'btn success')); ?>

</p>
