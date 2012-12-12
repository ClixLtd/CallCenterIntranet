<h2>Listing Proxies</h2>
<br>
<?php if ($proxies): ?>
<table class="zebra-striped datatable">
	<thead>
		<tr>
			<th>Host</th>
			<th>Port</th>
			<th>Fail count</th>
			<th>Use count</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($proxies as $proxy): ?>		<tr>

			<td><?php echo $proxy->host; ?></td>
			<td><?php echo $proxy->port; ?></td>
			<td><?php echo $proxy->fail_count; ?></td>
			<td><?php echo $proxy->use_count; ?></td>
			<td>
				<?php echo Html::anchor('proxies/view/'.$proxy->id, 'View'); ?> |
				<?php echo Html::anchor('proxies/edit/'.$proxy->id, 'Edit'); ?> |
				<?php echo Html::anchor('proxies/delete/'.$proxy->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Proxies.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('proxies/create', 'Add new Proxy', array('class' => 'btn success')); ?>

</p>
