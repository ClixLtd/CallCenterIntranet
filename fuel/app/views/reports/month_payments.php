<div style="float: right;">

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
		<div class="tab default-tab" id="quickview">
		
		  <article class="full-block">
				
				<div class="article-container">
					<section>
					
					   <table class="zebra-striped datatable" width="100%">
						<thead>
							<tr>
								<th>Month</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
						    <?php foreach($quickGraph AS $graphTotal): ?>
							<tr>
								<td><?php echo $graphTotal['month']; ?></td>
								<td><?php echo number_format($graphTotal['total'],0); ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

					
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
		
		
		<div class="tab" id="monthly">
			<article class="full-block">
				
				<div class="article-container">
					<section>
					<table class="zebra-striped datatable" width="100%">
						<thead>
							<tr>
								<th>ClientID</th>
								<th>Introducer</th>
								<th>Name</th>
								<th>Amount In</th>
								<th>Notes</th>
							</tr>
						</thead>
						<tbody>
						    <?php foreach($payments AS $pay): ?>
							<tr>
								<td <?php echo ($pay['reached']) ? '' : 'style="background-color: RGBA(200,0,0,0.05) !important;"'; ?>><?php echo $pay['ClientID']; ?></td>
								<td <?php echo ($pay['reached']) ? '' : 'style="background-color: RGBA(200,0,0,0.05) !important;"'; ?>><?php echo $pay['Introducer']; ?></td>
								<td <?php echo ($pay['reached']) ? '' : 'style="background-color: RGBA(200,0,0,0.05) !important;"'; ?>><?php echo $pay['Name']; ?></td>
								<td <?php echo ($pay['reached']) ? '' : 'style="background-color: RGBA(200,0,0,0.05) !important;"'; ?>>&pound;<?php echo number_format($pay['AmountIn'],2); ?></td>
								<td <?php echo ($pay['reached']) ? '' : 'style="background-color: RGBA(200,0,0,0.05) !important;"'; ?>><?php echo $pay['note']; ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					</section>
				</div>
								
			</article>
		</div>

	</section>
	
	

</article>
