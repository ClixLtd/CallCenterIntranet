<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2>Listing Database Servers</h2>
			
			<nav>
				<ul class="button-switch">
					<li><?php echo Html::anchor('database/server/create', 'Add new Database server', array('class' => 'button')); ?></li>
				</ul>
			</nav>
		</header>
	</div>
	
	<section>
	
		<?php if ($database_servers): ?>
		<table class="zebra-striped datatable">
			<thead>
				<tr>
					<th>Title</th>
					<th>Hostname</th>
					<th>Username</th>
					<th>Available Queries</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
		<?php foreach ($database_servers as $database_server): ?>		<tr>
		
					<td><?php echo $database_server->title; ?></td>
					<td><?php echo $database_server->hostname; ?></td>
					<td><?php echo $database_server->username; ?></td>
					<td><?php echo Html::anchor('database/query/'.$database_server->id, count($database_server->database_queries)); ?></td>
					<td>
						<?php echo Html::anchor('database/server/view/'.$database_server->id, 'View'); ?> |
						<?php echo Html::anchor('database/server/edit/'.$database_server->id, 'Edit'); ?> |
						<?php echo Html::anchor('database/server/delete/'.$database_server->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>
		
					</td>
				</tr>
		<?php endforeach; ?>	</tbody>
		</table>
		
		<?php else: ?>
		<p>No Database_servers.</p>
		
		<?php endif; ?>

	</section>

</article>