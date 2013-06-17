<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2>Change Office</h2>
		</header>
	</div>
	
	<section>
	
		<table>
			<tr>
				<th>Leadpool ID</th>
				<td><?php echo $leadpool; ?></td>
			</tr>
			<tr>
				<th>Office</th>
				<td></td>
			</tr>
			<tr>
				<th>Telesales</th>
				<td><select name="agent">
					<option value="null">-- NO CHANGE</option>
					<?php foreach ($allAgents as $agent): ?>
					<option value="<?php echo $agent['debtsolv_id']; ?>"><?php echo $agent['first_name']; ?> <?php echo $agent['last_name']; ?></option>
					<?php endforeach; ?>
				</select></td>
			</tr>
		</table>
	
	</section>
</article>
