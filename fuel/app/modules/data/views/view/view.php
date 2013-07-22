<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2>Data Report</h2>
			
			<nav>
				<ul class="tab-switch">
					<li><a class="default-tab" href="#quickview">Quick View</a></li>
                    <li><a href="#listResets">List Resets</a></li>
                    <li><a href="#validleads">Valid Leads</a></li>
					<li><a href="#invalidleads">Invalid Leads</a></li>
				</ul>
			</nav>
			
		</header>
	</div>
	
	<section>

    <div class="tab" id="listResets">
        <article class="full-block">
            <h3>List Resets</h3>

            <article class="full-block">
                <table>
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>User</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (count($importantDates['allResets']) > 0): ?>
                    <?php foreach ($importantDates['allResets'] as $reset): ?>
                    <tr>
                        <td><?php echo date("d/m/Y - H:i", strtotime($reset['date'])); ?></td>
                        <td><?php echo $reset['name']; ?></td>
                        <td><?php echo $reset['username']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="3"><b>No Resets have been done!</b></td>
                    </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </article>
        </article>
    </div>


    <div class="tab" id="invalidleads">
			<article class="full-block">
				<h3>Valid Leads</h3>
				
				<article class="full-block">
					<table id="table-invalidLeads">
						<thead>
							<tr>
								<th>Dialler ID</th>
								<th>Title</th>
								<th>First Name</th>
								<th>Surname</th>
								<th>Telephone</th>
								<th>Alt Telephone</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
		
						</tbody>
					</table>
					<script>
						$(document).ready(function() {
							$('#table-invalidLeads').dataTable( {
								"bProcessing": true,
								"bServerSide": true,
								"sAjaxSource": '/data/invalidleads/<?php echo $listID; ?>.json'
							} );
						} );
					</script>
				</article>
			</article>
		</div>
	
	
		<div class="tab" id="validleads">
			<article class="full-block">
				<h3>Valid Leads</h3>
				
				<article class="full-block">
					<table id="table-validLeads">
						<thead>
							<tr>
                                <th>Dialler ID</th>
                                <th>Title</th>
                                <th>First Name</th>
                                <th>Surname</th>
                                <th>Telephone</th>
                                <th>Alt Telephone</th>
                                <th>Status</th>
							</tr>
						</thead>
						<tbody>
		
						</tbody>
					</table>
					<script>
						$(document).ready(function() {
							$('#table-validLeads').dataTable( {
								"bProcessing": true,
								"bServerSide": true,
								"sAjaxSource": '/data/validleads/<?php echo $listID; ?>.json'
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

                <br class="clearfix" />

                <article class="half-block">

                    <div class="article-container">
                        <section>
                            <table>
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th>Date Added</th>
                                    <td><?php echo date('d/m/Y', strtotime($importantDates['added'])); ?></td>
                                </tr>
                                <tr>
                                    <th>Last Soft Reset</th>
                                    <td><?php echo (!isset($importantDates['lastSoft'])) ? "N/A" : date('d/m/Y', strtotime($importantDates['lastSoft']))." (".$importantDates['softCount'].")"; ?></td>
                                </tr>
                                <tr>
                                    <th>Last Hard Reset</th>
                                    <td><?php echo (!isset($importantDates['lastHard'])) ? "N/A" : date('d/m/Y', strtotime($importantDates['lastHard']))." (".$importantDates['hardCount'].")"; ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </section>
                    </div>

                </article>

                <article class="half-block clearrm">

                    <div class="article-container">
                        <section>

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
