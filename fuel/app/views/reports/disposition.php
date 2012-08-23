<div style="float: right;">
<?php if($view_all): ?>
<select name="center" rel="tooltip" title="Call Center">
	<option value="ALL">All Centers</option>
	<?php foreach($all_call_centers AS $cc): ?>
	<option value="<?php echo $cc->shortcode; ?>" <?php echo ($cc->shortcode == $center) ? "SELECTED" : ""; ?>><?php echo $cc->title; ?></option>
	<?php endforeach; ?>
</select>
<?php endif; ?>
<input type="text" class="datepicker" name="startdate" id="startdate" rel="tooltip" title="Start Date" value="<?php echo (!is_null($start_date)) ? $start_date : "" ; ?>">
<input type="text" class="datepicker" name="enddate" id="enddate" rel="tooltip" title="End Date" value="<?php echo (!is_null($end_date)) ? $end_date : "" ; ?>">
<a href='#' class="button" id="dateRangeDisposition">View Date Range</a>
</div>

<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2>Disposition Report</h2>
			
			<?php if (count($query_results) > 0): ?>
			<nav>
				<ul class="tab-switch">
					<li><a class="default-tab" href="#tab0">Visualisation</a></li>
					<li><a href="#tab1">All Data</a></li>
				</ul>
			</nav>
			<?php endif; ?>
			
		</header>
	</div>
	
	<?php if (count($query_results) > 0): ?>
	
	<section>
	
	<div class="tab default-tab" id="tab0">
		
		<article class="half-block clearrm">

			<h3>Lead Status</h3>
			<table class="data" data-chart="pie">
				<thead>
					<tr>
						<td></td>
						<th scope="col">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($pie_dispositions AS $id => $count) : ?>
					<tr>
						<th scope="row"><?php echo $id; ?></th>
						<td><?php echo $count; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		
		</article>
		
		<article class="half-block clearrm">
		
			<h3>Data Files</h3>
			<table class="data" data-chart="pie">
				<thead>
					<tr>
						<td></td>
						<th scope="col">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($pie_lead_sources AS $id => $count) : ?>
					<tr>
						<th scope="row"><?php echo $id; ?></th>
						<td><?php echo $count; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			
		</article>
		
		<div class="clearfix"></div>
	
		<article class="full-block">
		
			<h3>Consolidators</h3>
			<table class="data" data-chart="bar">
				<thead>
					<tr>
						<td></td>
						<th scope="col">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($pie_consolidators AS $id => $count) : ?>
					<tr>
						<th scope="row"><?php echo $id; ?></th>
						<td><?php echo $count; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			
		</article>
		
		<div class="clearfix"></div>
	
		<article class="full-block">
		
			<h3>Telesales</h3>
			<table class="data" data-chart="bar">
				<thead>
					<tr>
						<td></td>
						<th scope="col">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($pie_telesales AS $id => $count) : ?>
					<tr>
						<th scope="row"><?php echo $id; ?></th>
						<td><?php echo $count; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			
		</article>

	
	</div>
	
	
	<div class="tab" id="tab1">
		<table class="zebra-striped datatable">
			<thead>
				<tr>
		<?php foreach ($query_columns AS $column): ?>
					<th><?php echo $column; ?></th>
		<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
		<?php foreach ($query_results as $query_result): ?>
				<tr>
		<?php foreach ($query_columns AS $column): ?>
					<td><?php echo $query_result[$column]; ?></td>
		<?php endforeach; ?>
				</tr>
		<?php endforeach; ?>	</tbody>
		</table>
	</div>

	</section>

	<?php else: ?>
	
	<section>
	
	<div class="tab default-tab" id="tab0">
		
		<article class="full-block clearrm">
		
		<div class="notification error">
			<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
			<p>
				<b>No Data available for this date range.</b>
			</p>
		</div>
		
		
		
		</article>
		
	</div>
	</section>
	
	
	<?php endif; ?>

</article>