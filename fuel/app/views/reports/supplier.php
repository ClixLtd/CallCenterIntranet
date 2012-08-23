<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2><?php echo $list_title; ?></h2>
			
			<nav>
				<ul class="tab-switch">
					<li><a class="default-tab" href="#quickview">Quick View</a></li>
					<li><a href="#referrals">Referrals</a></li>
					<li><a href="#packouts">Pack Outs</a></li>
					<li><a href="#packins">Pack Ins</a></li>
					<li><a href="#payments">Payments</a></li>
					<li><a href="#supplierpayouts">Supplier Payouts</a></li>
				</ul>
			</nav>
			
		</header>
	</div>
	
	<?php if (count($list_stats) > 0): ?>
	
	<section>
	
	
	<div class="tab" id="supplierpayouts">
		<article class="full-block">
			<h3>Supplier Payouts</h3>
			
			<article class="full-block">
				<table id="supplierpayouts_table"></table>
			
				<script>
					$(document).ready(function() {
						$.ajax({
							"url" : "/reports/supplier_payouts/<?php echo $campaign_id; ?>.json",
							"success": function ( json ) {
								if (json['error']) {
									alert(json['error']);
								} else {
									$('#supplierpayouts_table').dataTable(json)
									$('#supplier_payments_available').html(json['totalPayments']);
								}
							},
							"dataType": "json"
						});
					})
				</script>

			</article>
			
		</article>
	</div>
	
	
	<div class="tab default-tab" id="quickview">
		<article class="full-block">
		
			<h3>List Statistics</h3>
						
			<article class="full-block">
				
				<table class="zebra-striped datatable">
					<thead>
						<tr>
				<?php foreach ($list_stats_headings AS $column): ?>
							<th><?php echo $column; ?></th>
				<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
				<?php foreach ($list_stats as $query_result): ?>
						<tr>
				<?php foreach ($list_stats_headings AS $column): ?>
							<td>
								<?php echo $query_result[$column]; ?>
							</td>
				<?php endforeach; ?>
						</tr>
				<?php endforeach; ?>	</tbody>
				</table>

			</article>
			
		</article>
		
		<div class="clearfix"></div>
		
		<article class="half-block">
			
			<div class="article-container">
				<header>
					<h2>List DI Values</h2>
				</header>
			
				<section>
				<table class="zebra-striped">
					<tbody>
						<tr>
							<td>Total Pack Out DI</td>
							<td>&pound;<?php echo number_format($total_values['pack_outs'],2); ?></td>
						</tr>
						<tr>
							<td>Total Pack In DI</td>
							<td>&pound;<?php echo number_format($total_values['pack_ins'],2); ?></td>
						</tr>
						<tr>
							<td>Total Payments</td>
							<td>&pound;<?php echo number_format($total_values['payments'],2); ?></td>
						</tr>
					</tbody>
				</table>
				</section>
			</div>
			
		</article>


		<article class="half-block clearrm">
			
			<div class="article-container">
				<header>
					<h2>Supplier Payment Details</h2>
				</header>
			
			
				<section>
				<table class="zebra-striped">
					<tbody>
						<tr>
							<td>Payments Available</td>
							<td><div id="supplier_payments_available"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
						</tr>
					</tbody>
				</table>
				</section>
			</div>
			
		</article>

		

	
	</div>
	
	<?php if (count($payments) > 0): ?>
	<div class="tab" id="payments">
		<article class="full-block">
		
			<h3>Payments</h3>
			
			<table class="zebra-striped datatable">
				<thead>
					<tr>
			<?php foreach ($payment_headings AS $column): ?>
						<th><?php echo $column; ?></th>
			<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
			<?php foreach ($payments as $query_result): ?>
					<tr>
			<?php foreach ($payment_headings AS $column): ?>
						<td><?php echo $query_result[$column]; ?></td>
			<?php endforeach; ?>
					</tr>
			<?php endforeach; ?>	</tbody>
			</table>
			
		</article>
	</div>
	<?php else: ?>
	<div class="tab" id="payments">
		<article class="full-block">
			<div class="notification error">
				<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
				<p>
					<b>No Data available currently.</b>
				</p>
			</div>
		</article>
	</div>
	<?php endif; ?>
	
		<?php if (count($pack_ins) > 0): ?>
		<div class="tab" id="packins">
		<article class="full-block">
		
			<h3>Pack In</h3>
			
			<table class="zebra-striped datatable">
				<thead>
					<tr>
			<?php foreach ($pack_in_headings AS $column): ?>
						<th><?php echo $column; ?></th>
			<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
			<?php foreach ($pack_ins as $query_result): ?>
					<tr>
			<?php foreach ($pack_in_headings AS $column): ?>
						<td><?php echo $query_result[$column]; ?></td>
			<?php endforeach; ?>
					</tr>
			<?php endforeach; ?>	</tbody>
			</table>
			
		</article>
	</div>
	<?php else: ?>
	<div class="tab" id="packins">
		<article class="full-block">
			<div class="notification error">
				<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
				<p>
					<b>No Data available currently.</b>
				</p>
			</div>
		</article>
	</div>
	<?php endif; ?>
	
	<?php if (count($pack_outs) > 0): ?>
	<div class="tab" id="packouts">
		<article class="full-block">
		
			<h3>Pack Outs</h3>
			
			<table class="zebra-striped datatable">
				<thead>
					<tr>
			<?php foreach ($pack_out_headings AS $column): ?>
						<th><?php echo $column; ?></th>
			<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
			<?php foreach ($pack_outs as $query_result): ?>
					<tr>
			<?php foreach ($pack_out_headings AS $column): ?>
						<td><?php echo $query_result[$column]; ?></td>
			<?php endforeach; ?>
					</tr>
			<?php endforeach; ?>	</tbody>
			</table>
			
		</article>
	</div>
	<?php else: ?>
	<div class="tab" id="packouts">
		<article class="full-block">
			<div class="notification error">
				<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
				<p>
					<b>No Data available currently.</b>
				</p>
			</div>
		</article>
	</div>
	<?php endif; ?>
	
	<?php if (count($list_dispositions) > 0): ?>
	<div class="tab" id="referrals">
		<article class="full-block">
		
			<h3>Referral Details</h3>
			
			<table class="zebra-striped datatable">
				<thead>
					<tr>
			<?php foreach ($list_dispositions_headings AS $column): ?>
						<th><?php echo $column; ?></th>
			<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
			<?php foreach ($list_dispositions as $query_result): ?>
					<tr>
			<?php foreach ($list_dispositions_headings AS $column): ?>
						<td><?php echo $query_result[$column]; ?></td>
			<?php endforeach; ?>
					</tr>
			<?php endforeach; ?>	</tbody>
			</table>
			
		</article>
	</div>
	<?php else: ?>
	<div class="tab" id="referrals">
		<article class="full-block">
			<div class="notification error">
				<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
				<p>
					<b>No Data available currently.</b>
				</p>
			</div>
		</article>
	</div>
	<?php endif; ?>
	
	
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