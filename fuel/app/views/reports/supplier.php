<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2><?php echo $list_title; ?></h2>
			
			<nav>
				<ul class="tab-switch">
					<li><a class="default-tab" href="#quickview">Quick View</a></li>
					<li><a href="#diallerdata">Dialler Data</a></li>
					<li><a href="#referrals">Referrals</a></li>
					<li><a href="#packouts">Pack Outs</a></li>
					<li><a href="#packins">Pack Ins</a></li>
					<li><a href="#payments">Payments</a></li>
					<li><a href="#supplierpayouts">Supplier Payouts</a></li>
					<li><a href="#remittance">Remittance</a></li>
				</ul>
			</nav>
			
		</header>
	</div>
	
	<?php if (count($list_stats) > 0): ?>
	
	<section>
	
	
	<div class="tab" id="remittance">
		<nav style="margin-bottom: 10px;">
			<select id="remittance-choices">
			</select>
			
			<div id="gablogo" style="text-align: right; display: none;">
				<?php echo Html::anchor('/', '<img src="/assets/img/gablogo.png">'); ?>
			</div>
			
			<div id="date-view" style="display: none;">
			</div>
		</nav>
		
		<div class="clearfix"></div>
		
		<article class="full-block">
			<table id="remittance-table">
				<thead>
					<tr>
						<th>Client ID</th>
						<th>Dialler List</th>
						<th>Client Name</th>
						<th>Payment</th>
						<th>Owed</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</article>
	</div>
	
	
	
	<div class="tab" id="diallerdata">
		<article class="full-block">
			<h3>Supplier Payouts</h3>
			
			<article class="full-block">
				<table id="diallerdata_table"></table>
				
				<script>
					$(document).ready(function() {
					
						$.ajax({
							"url" : "/reports/list_reports/<?php echo $campaign_id; ?>.json",
							"success": function ( json ) {
								if (json['error']) {
									alert(json['error']);
								} else {
									$('#diallerdata_table').dataTable(json)
								}
							},
							"dataType": "json"
						});
					
					})
				</script>

			</article>
			
		</article>
	</div>
	
	
	<div class="tab" id="supplierpayouts">
		<article class="full-block">
			<h3>Supplier Payouts</h3>
			
			<article class="full-block">
				<table id="supplierpayouts_table"></table>
			
				<script>
					$(document).ready(function() {
					
						var remittanceDetails = "";
						
						$("#remittance-choices").change(function () {
							setRemittance($(this).val());
						});
						
					
						function addCommas(nStr)
						{
							nStr = nStr.toFixed(2);
							nStr += '';
							x = nStr.split('.');
							x1 = x[0];
							x2 = x.length > 1 ? '.' + x[1] : '';
							var rgx = /(\d+)(\d{3})/;
							while (rgx.test(x1)) {
								x1 = x1.replace(rgx, '$1' + ',' + '$2');
							}
							return x1 + x2;
						}
					
						function setRemittance(dateString)
						{
							$("#date-view").html("Remittance for " + dateString);
						
							$("#remittance-table tbody").html("");
						
							var secondTotal = 0;
							var firstTotal = 0;
							
							firstPayments = remittanceDetails['first'][dateString];
							secondPayments = remittanceDetails['second'][dateString];
							
							$("#remittance-table tbody").append('<tr><th colspan="5">First Payments This Month</th></th>');
							
							if (firstPayments === undefined)
							{
								$("#remittance-table tbody").append('<tr><td colspan="5">No First Payments this Month.</td></tr>');
							} else {
								
								$.each(firstPayments, function(key, data) {
									$("#remittance-table tbody").append('<tr><td>'+data['ClientID']+'</td><td>'+data['ListName']+'</td><td>'+data['Name']+'</td><td>&pound;'+addCommas((data['DI']/100))+'</td><td>&pound;'+addCommas(((data['DI']*0.75)/100))+'</td></tr>');
									firstTotal = firstTotal + ((data['DI']*0.75)/100);
								})
								$("#remittance-table tbody").append('<tr><td align="right" style="text-align: right;" colspan="4"><b>First Payments Value : </b></td><td><b>&pound;'+addCommas(firstTotal)+'</b></td></tr>');
							}
							
							$("#remittance-table tbody").append('<tr><th colspan="5">Second Payments This Month</th></th>');
							
							if (secondPayments === undefined)
							{
								$("#remittance-table tbody").append('<tr><td colspan="5">No Second Payments this Month.</td></tr>');
							} else {
								
								$.each(secondPayments, function(key,data) {
									$("#remittance-table tbody").append('<tr><td>'+data['ClientID']+'</td><td>'+data['ListName']+'</td><td>'+data['Name']+'</td><td>&pound;'+addCommas((data['DI']/100))+'</td><td>&pound;'+addCommas(((data['DI']*0.5)/100))+'</td></tr>');
									secondTotal = secondTotal + ((data['DI']*0.5)/100);
								})
								$("#remittance-table tbody").append('<tr><td align="right" style="text-align: right;" colspan="4"><b>Second Payments Value : </b></td><td><b>&pound;'+addCommas(secondTotal)+'</b></td></tr>');
								
								
								
							}
							
							$("#remittance-table tbody").append('<tr><th align="right" style="text-align: right;" colspan="4"><b>Total Payment : </b></th><th><b>&pound;'+addCommas((firstTotal+secondTotal))+'</b></th></tr>');
							
						}
					
						$.ajax({
							"url" : "/reports/supplier_payouts/<?php echo $campaign_id; ?>.json",
							"success": function ( json ) {
								if (json['error']) {
									alert(json['error']);
								} else {
									$('#supplierpayouts_table').dataTable(json)
									$('#supplier_payments_available').html(json['totalPayments']);
									
									remittanceDetails = json['allClientsMonthly'];
									
									$.each(json['allClientsMonths'], function(index, value) {
										$("#remittance-choices").append('<option>' + value + '</option>');
									})
									
									setRemittance(json['allClientsMonths'][0]);
									
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
							<th><input type="checkbox"></th>
				<?php foreach ($list_stats_headings AS $column): ?>
							<th><?php echo $column; ?></th>
				<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
				<?php foreach ($list_stats as $query_result): ?>
						<tr>
							<td><input type="checkbox"></td>
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
		
		
		<article class="full-block">
			
			<div class="article-container">
				<header>
					<h2>Conversion Ratios Over Dates</h2>
				</header>
			
				<section>
				
					<div id="conversionRatioChart" style="width: 100%; height: 500px;"></div>
					
					<script>
					$(function () {
					
var conversionData = {
	<?php foreach($conversions AS $list=>$conversion): ?>
"<?php echo $list; ?>": {
		label: "<?php echo $list; ?>",
		data: [ <?php foreach($conversion AS $date=>$ratio): ?>[<?php echo (((int)strtotime($date))*1000); ?>,<?php echo $ratio; ?>], <?php endforeach; ?>]
	},
<?php endforeach; ?>
}
						var data = [];
						
						$.each(conversionData, function(key, values) {
							
							data.push(values);
						
						});
						
						$.plot(
							$("#conversionRatioChart"), 
							data,
							{
							    xaxis: {
							        mode: "time"
							    },
							    series: {
				                   lines: { show: true },
				                   points: { show: true }
				               },
				               crosshair: { mode: "x" },
				               grid: { hoverable: true, }
							}
						);

						
					});
					</script>
				</section>
				
			</div>
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