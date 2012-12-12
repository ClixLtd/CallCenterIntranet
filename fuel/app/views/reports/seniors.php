<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2><?php echo $list_title; ?></h2>
			
			<nav>
				<ul class="tab-switch">
					<li><a class="default-tab" href="#quickview">All Clients</a></li>
					<li><a href="#packouts">Pack Outs</a></li>
					<li><a href="#packins">Pack Ins</a></li>
					<li><a href="#payments">Payments</a></li>
				</ul>
			</nav>
			
		</header>
	</div>
	
	<?php if (count($all_clients['data']) > 0): ?>
	
	<section>
	
		<div class="tab default-tab" id="quickview">
			<article class="full-block">
			
				<h3>All Clients</h3>
							
				<article class="full-block">
					
					<table class="zebra-striped datatable">
						<thead>
							<tr>
					<?php foreach ($all_clients['headings'] AS $column): ?>
								<th><?php echo $column; ?></th>
					<?php endforeach; ?>
							</tr>
						</thead>
						<tbody>
					<?php foreach ($all_clients['data'] as $query_result): ?>
							<tr>
					<?php foreach ($all_clients['headings'] AS $column): ?>
								<td>
									<?php echo $query_result[$column]; ?>
								</td>
					<?php endforeach; ?>
							</tr>
					<?php endforeach; ?>	</tbody>
					</table>
	
				</article>
				
			</article>
			
			<article class="half-block">
			
				<table class="zebra-striped">
					<thead>
						<tr>
							<th></th>
							<th>Value</th>
						</tr>
					</thead>
				
					<tbody>
						<tr>
							<td>Total Pack In DI</td>
							<td>&pound;<?php echo number_format($total_values['pack_in'],0); ?></td>
						</tr>
						<tr>
							<td>Total Payments</td>
							<td>&pound;<?php echo number_format($total_values['payments'],0); ?></td>
						</tr>
					</tbody>
				</table>
			
			</article>
			
		</div>
		
		
		
		<div class="tab" id="packins">
			<article class="full-block">
			
				<h3>Pack Ins</h3>
							
				<article class="full-block">
					
					<table class="zebra-striped datatable">
						<thead>
							<tr>
					<?php foreach ($pack_ins['headings'] AS $column): ?>
								<th><?php echo $column; ?></th>
					<?php endforeach; ?>
							</tr>
						</thead>
						<tbody>
					<?php foreach ($pack_ins['data'] as $query_result): ?>
							<tr>
					<?php foreach ($pack_ins['headings'] AS $column): ?>
								<td>
									<?php echo $query_result[$column]; ?>
								</td>
					<?php endforeach; ?>
							</tr>
					<?php endforeach; ?>	</tbody>
					</table>
	
				</article>
				
			</article>
		</div>

	
	
		<div class="tab" id="payments">
			<article class="full-block">
			
				<h3>Payments</h3>
							
				<article class="full-block">
					
					<table class="zebra-striped datatable">
						<thead>
							<tr>
					<?php foreach ($payments['headings'] AS $column): ?>
								<th><?php echo $column; ?></th>
					<?php endforeach; ?>
							</tr>
						</thead>
						<tbody>
					<?php foreach ($payments['data'] as $query_result): ?>
							<tr>
					<?php foreach ($payments['headings'] AS $column): ?>
								<td>
									<?php echo $query_result[$column]; ?>
								</td>
					<?php endforeach; ?>
							</tr>
					<?php endforeach; ?>	</tbody>
					</table>
	
				</article>
				
			</article>
		</div>
	
	</section>

	<?php else: ?>
	
	<section>
	
	<div class="tab default-tab" id="quickview">
		
		<article class="full-block clearrm">
		
		<div class="notification error">
			<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
			<p>
				<b>No Data available currently.</b>
			</p>
		</div>
		
		
		
		</article>
		
	</div>
	</section>
	
	
	<?php endif; ?>

</article>