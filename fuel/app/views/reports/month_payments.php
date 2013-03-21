<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2>Monthly Payments</h2>
			
			<nav>
				<ul class="tab-switch">
					<li><a class="default-tab" href="#quickview">Payments</a></li>
				</ul>
			</nav>
			
		</header>
	</div>
	
	<section>
		<div class="tab default-tab" id="quickview">
			<article class="full-block">
				<h3></h3>
				
				<article class="half-block">
				
				<div class="article-container">
					<section>
					<table class="zebra-striped datatable" width="100%">
						<thead>
							<tr>
								<th>ClientID</th>
								<th>Name</th>
								<th>Amount In</th>
								<th>Notes</th>
							</tr>
						</thead>
						<tbody>
						    <?php foreach($payments AS $pay): ?>
							<tr <?php echo ($pay['reached']) ? '' : 'style="background-color: RGBA(200,0,0,0.3) !important;"'; ?>>
								<td><?php echo $pay['ClientID']; ?></td>
								<td><?php echo $pay['Name']; ?></td>
								<td>&pound;<?php echo number_format($pay['AmountIn'],2); ?></td>
								<td><?php echo $pay['note']; ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					</section>
				</div>
				
			</article>

				
			</article>
		</div>

	</section>
	
	

</article>
