<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2>Telesales Report</h2>
		</header>
	</div>
	<section>

		<div>
			<article class="full-block">
				<table id="nocontacts_table" width="100%">
    				<tr>
    				    <th>Name</th>
    				    <th>Referrals</th>
    				    <th>Pack Outs</th>
    				    <th>Conversion Rate</th>
    				    <th>Points</th>
    				    <th>Commission</th>
    				</tr>
    				
    				<?php foreach($results AS $result): ?>
    				<tr>
    				    <td><?php echo $result['name']; ?></td>
    				    <td><?php echo $result['referrals']; ?></td>
    				    <td><?php echo $result['packouts']; ?></td>
    				    <td><?php echo $result['conversionrate']; ?>%</td>
    				    <td><?php echo $result['points']; ?></td>
    				    <td>£<?php echo $result['commission']; ?></td>
    				</tr>
    				<?php endforeach; ?>
    				
				</table>
			</article>
		</div>
		
	</section>
	
	

</article>

