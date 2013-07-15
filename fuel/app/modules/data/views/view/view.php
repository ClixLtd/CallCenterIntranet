<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2>Data Report</h2>
			
			<nav>
				<ul class="tab-switch">
					<li><a class="default-tab" href="#quickview">Quick View</a></li>
				</ul>
			</nav>
			
		</header>
	</div>
	
	<section>
		<div class="tab default-tab" id="quickview">
			<article class="full-block">
				<h3>Quick View</h3>
				
				<article class="half-block">
					
					<div class="article-container">
						<section>
							<table class="zebra-striped">
								<tbody>
									<tr>
										<td><b>Leads Purchased</b></td>
										<td><?php echo number_format($basicStats['purchased'],0); ?></td>
									</tr>
									<tr>
										<td><b>Leads Contacted</b></td>
										<td><?php echo number_format($basicStats['contacted'],0); ?></td>
									</tr>
									<tr>
										<td><b>Referrals</b></td>
										<td><?php echo number_format($basicStats['referrals'],0); ?></td>
									</tr>
									<tr>
										<td><b>Packs Out</b></td>
										<td><?php echo number_format($basicStats['packout'],0); ?></td>
									</tr>
									<tr>
										<td><b>Packs In</b></td>
										<td><?php echo number_format($basicStats['packin'],0); ?></div></td>
									</tr>
									<tr>
										<td><b>Paid Clients</b></td>
										<td><?php echo number_format($basicStats['paid'],0); ?></td>
									</tr>
								</tbody>
							</table>
						</section>
					</div>
					
				</article>


				<article class="half-block clearrm">
					
					<div class="article-container">
						<section>
							<table class="zebra-striped">
								<tbody>
									<tr>
										<td><b>Leads Purchased</b></td>
										<td><?php echo number_format($basicStats['purchased'],0); ?></td>
									</tr>
									<tr>
										<td><b>Cost Per Lead</b></td>
										<td><div id="dr_pack_out_count"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
									</tr>
									<tr>
										<td><b>Cost Per Dialable Lead</b></td>
										<td><div id="dmplus_pack_out_count"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
									</tr>
									<tr>
										<td><b>Leads Contacted</b></td>
										<td><div id="referral_count"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
									</tr>
									<tr>
										<td><b>Cost Per Contact</b></td>
										<td><div id="pack_in_count"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
									</tr>
									<tr>
										<td><b>Referrals</b></td>
										<td><div id="paid_in_count"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
									</tr>
									<tr>
										<td><b>Packs Out</b></td>
										<td><div id="paid_in_count"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
									</tr>
									<tr>
										<td><b>Packs In</b></td>
										<td><div id="paid_in_count"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
									</tr>
									<tr>
										<td><b>Paid Clients</b></td>
										<td><div id="paid_in_count"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
									</tr>
								</tbody>
							</table>
						</section>
					</div>
					
				</article>

				
			</article>
		</div>

	</section>


</article>
