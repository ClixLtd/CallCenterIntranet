<div style="float: right;">


<select name="center" id="center" rel="tooltip" title="Select Call Center">
    <option value="GAB">Expert Money Solutions</option>
    <option value="RESOLVE">Resolve</option>
</select>

<select name="month" id="month" rel="tooltip" title="Select Month and Year">

    <?php 
    for ($i = 0; $i <= 18; $i++) {
    
        $date = strtotime("-".$i." months");
        echo '<option value="'.date("m-Y", $date).'">'.date("F Y", $date).'</option>';
    
    }
    ?>
    
</select>

</div>

<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2>Monthly Payments</h2>
			
			<nav>
				<ul class="tab-switch">
					<li><a class="default-tab" href="#quickview">Quick View</a></li>
					<li><a href="#expected">Expected Payments</a></li>
					<li><a href="#monthly">Payments Made</a></li>
				</ul>
			</nav>
			
		</header>
	</div>
	
	<section>
		<div id="loading_data"><span class="loader red" title="Loading, please wait&#8230;" style="margin-right: 30px;"></span> Loading Disposition Report - Please Wait!</div>
	</section>
	
	<section>
		<div class="tab default-tab" id="quickview">
		
		  <article class="full-block">
				
				<div class="article-container">
					<section>
					   
					   
					   <?php echo $reports['monthlyStats']; ?>
					   
					   					
					</section>
					
				</div>
				
		  </article>
		
		
			<article class="half-block">
				
				<div class="article-container">
					<section>
					<table class="zebra-striped datatable" width="100%">
						<thead>
							<tr>
								<th>Introducer</th>
								<th>Total Payments</th>
								<th>Total Value</th>
								<th>Average Payment</th>
							</tr>
						</thead>
						<tbody>
						    <?php foreach($introducer AS $name => $totals): ?>
							<tr>
								<td><?php echo $name; ?></td>
								<td><?php echo number_format($totals['total'],0); ?></td>
								<td>&pound;<?php echo number_format($totals['amount'],2); ?></td>
								<td>&pound;<?php echo number_format(($totals['amount']/$totals['total']),2); ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					</section>
				</div>
								
			</article>
		</div>

		<div class="tab" id="expected">
			<article class="full-block">
				
				<div class="article-container">
					<section>
					<table class="zebra-striped datatable" width="100%">
						<thead>
							<tr>
								<th>ClientID</th>
								<th>Name</th>
								<th>Date Expected</th>
								<th>Amount Expected</th>
								<th>Received</th>
								<th>Completed</th>
							</tr>
						</thead>
						<tbody>
						    <?php foreach($expected AS $pay): ?>
							<tr>
								<td <?php echo ($pay['complete']) ? '' : 'style="background-color: RGBA(200,0,0,0.1) !important;"'; ?>><?php echo $pay['clientID']; ?></td>
								<td <?php echo ($pay['complete']) ? '' : 'style="background-color: RGBA(200,0,0,0.1) !important;"'; ?>><?php echo $pay['name']; ?></td>
								<td <?php echo ($pay['complete']) ? '' : 'style="background-color: RGBA(200,0,0,0.1) !important;"'; ?>><?php echo $pay['dateExpected']; ?></td>
								<td <?php echo ($pay['complete']) ? '' : 'style="background-color: RGBA(200,0,0,0.1) !important;"'; ?>>&pound;<?php echo number_format($pay['amountExpected'],2); ?></td>
								<td <?php echo ($pay['complete']) ? '' : 'style="background-color: RGBA(200,0,0,0.1) !important;"'; ?>>&pound;<?php echo number_format($pay['received'],2); ?></td>
								<td <?php echo ($pay['complete']) ? '' : 'style="background-color: RGBA(200,0,0,0.1) !important;"'; ?>><?php echo ($pay['complete']) ? 'Complete' : 'Incomplete'; ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					</section>
				</div>
								
			</article>
		</div>

		<div class="tab" id="monthly">
			<article class="full-block">
				
				<div class="article-container">
					<section>
					<table class="zebra-striped" width="100%" id="payments-master"></table>
					</section>
				</div>
								
			</article>
		</div>

	</section>
	
	

</article>





<script>
    var disposition_url = "<?php echo $report_url; ?>";
    
	$(document).ready(function() {
    	
    	$('#month').change(function() {
        	
        	disposition_url = "/reports/get_monthly_payment/" + $("#center").val() + "/" + $("#month").val() + ".json";
        	load_reports();
        	        	
    	});
    	
    });
    
    function load_reports()
    {
        $('#loading_data').fadeIn();
    
        $.ajax({
        	"url" : disposition_url,
        	"success": function ( json ) {
        	    
        	    $('#loading_data').fadeOut();
        	    
            	
            	$('#payments').empty();
            	$('#payments-master').dataTable(json['payments']);
            	
            	
        	
        	}
        });
    }
</script>

