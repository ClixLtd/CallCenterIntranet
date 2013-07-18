<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2>Data Report</h2>
			
			<nav>
				<ul class="tab-switch">
					<li><a class="default-tab" href="#quickview">Quick View</a></li>
					<li><a href="#validleads">Valid Leads</a></li>
					<li><a href="#invalidleads">Invalid Leads</a></li>
				</ul>
			</nav>
			
		</header>
	</div>
	
	<section>
		<div class="tab" id="validleads">
			<article class="full-block">
				<h3>Valid Leads</h3>
				
				<article class="full-block">
					<table id="table-validLeads">
						<thead>
						
						</thead>
						<tbody>
		
						</tbody>
					</table>
					<script>
						$(document).ready(function() {
							$('#table-validLeads').dataTable( {
								"bProcessing": true,
								"sAjaxSource": 'https://intranet.gregsonandbrooke.co.uk/data/validleads/15.json'
							} );
						} );
					</script>
				</article>
			</article>
		</div>
		
	
	
	
	
		<div class="tab default-tab" id="quickview">
			<article class="full-block">
				<h3>Quick View</h3>
				
				<article class="half-block">
					
					<div class="article-container">
						<section>
							<table class="zebra-striped">
								<thead>
									<tr>
										<th></th>
										<th>Total</th>
										<th>%</th>
										<th>Cost Per</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><b>Leads Purchased</b></td>
										<td><?php echo number_format($basicStats['purchased'],0); ?></td>
										<td></td>
										<td>&pound;<?php echo number_format($basicStats['cost']/$basicStats['purchased'],2); ?></td>
									</tr>
									<tr>
										<td><b>Dialable Leads</b></td>
										<td><?php echo number_format($basicStats['dialable'],0); ?></td>
										<td><?php echo number_format(($basicStats['dialable']/$basicStats['purchased'])*100,1); ?>%</td>
										<td>&pound;<?php echo number_format($basicStats['cost']/$basicStats['dialable'],2); ?></td>
									</tr>
									<tr>
										<td><b>Leads Contacted</b></td>
										<td><?php echo number_format($basicStats['contacted'],0); ?></td>
										<td><?php echo number_format(($basicStats['contacted']/$basicStats['dialable'])*100,1); ?>%</td>
										<td>&pound;<?php echo number_format($basicStats['cost']/$basicStats['contacted'],2); ?></td>
									</tr>
									<tr>
										<td><b>Referrals</b></td>
										<td><?php echo number_format($basicStats['referrals'],0); ?></td>
										<td><?php echo number_format(($basicStats['referrals']/$basicStats['contacted'])*100,1); ?>%</td>
										<td>&pound;<?php echo number_format($basicStats['cost']/$basicStats['referrals'],2); ?></td>
									</tr>
									<tr>
										<td><b>Packs Out</b></td>
										<td><?php echo number_format($basicStats['packout'],0); ?></td>
										<td><?php echo number_format(($basicStats['packout']/$basicStats['referrals'])*100,1); ?>%</td>
										<td>&pound;<?php echo number_format($basicStats['cost']/$basicStats['packout'],2); ?></td>
									</tr>
									<tr>
										<td><b>Packs In</b></td>
										<td><?php echo number_format($basicStats['packin'],0); ?></td>
										<td><?php echo number_format(($basicStats['packin']/$basicStats['packout'])*100,1); ?>%</td>
										<td>&pound;<?php echo number_format($basicStats['cost']/$basicStats['packin'],2); ?></td>
									</tr>
									<tr>
										<td><b>Paid Clients</b></td>
										<td><?php echo number_format($basicStats['paid'],0); ?></td>
										<td>	<?php echo number_format(($basicStats['paid']/$basicStats['packin'])*100,1); ?>%</td>
										<td>&pound;<?php echo number_format($basicStats['cost']/$basicStats['paid'],2); ?></td>
									</tr>
								</tbody>
							</table>
						</section>
					</div>
					
				</article>
				
				
				<article class="half-block clearrm">
					
					<div class="article-container">
						<section>
							<div id="pieStatus" class="flotChart" style="height: 400px;"></div>
						</section>
					</div>
					
				</article>
				
				
				
			</article>
		</div>

	</section>


</article>


<script>

$(function () {


var data = [
<?php echo $statuses; ?>
];



$.plot($("#pieStatus"), data, 
{
	series: {
		pie: { 
			show: true,
			combine: {
                    color: '#999',
                    threshold: 0.01
                }
		},
        grid: {
            hoverable: true,
            clickable: true
        }
	},
    legend: {
        show: false
    }
});


});

</script>
