<div style="float: right;">
<input type="text" class="datepicker" name="startdate" id="startdate" rel="tooltip" title="Start Date" value="<?php echo (!is_null($start_date)) ? $start_date : "" ; ?>">
<input type="text" class="datepicker" name="enddate" id="enddate" rel="tooltip" title="End Date" value="<?php echo (!is_null($end_date)) ? $end_date : "" ; ?>">
<a href='#' class="button" id="dateRangeDisposition">View Date Range</a><br />
<?php if($view_all): ?>
<select name="center" rel="tooltip" title="Call Center" class="cd-dropdown cd-select" id="center" >
	<option value="-1">All Centers</option>
	<?php foreach($all_call_centers AS $cc): ?>
	<option value="<?php echo $cc->shortcode; ?>" <?php echo ($cc->shortcode == $center) ? "SELECTED" : ""; ?>><?php echo $cc->title; ?></option>
	<?php endforeach; ?>
</select>
<?php endif; ?>
</div>

<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2>External Survey Report</h2>
			
		</header>
	</div>
	
	<section>
		<div id="loading_data"><span class="loader red" title="Loading, please wait&#8230;" style="margin-right: 30px;"></span> Loading Disposition Report - Please Wait!</div>
	</section>
	
	<section>

		<div id="surveys">
			<article class="full-block">
				<h3>Completed Surveys</h3>
				
				<table class="zebra-striped datatable" width="100%">
    				<thead>
    				    <tr>
    				        <th>Referral ID</th>
    				        <th>Name</th>
    				        <th>Agent Name</th>
    				        <th>Center</th>
    				        <th>List ID</th>
    				        <th>Date</th>
    				        <th>Time</th>
    				        <th>Status</th>
    				    </tr>
    				</thead>
    				
    				<tbody>
    				    <?php foreach ($results as $result): ?>
    				    <tr>
    				        <td><?php echo $result[0]; ?></td>
    				        <td><?php echo $result[1]; ?></td>
    				        <td><?php echo $result[2]; ?></td>
    				        <td><?php echo $result[3]; ?></td>
    				        <td><?php echo $result[4]; ?></td>
    				        <td><?php echo $result[5]; ?></td>
    				        <td><?php echo $result[6]; ?></td>
    				        <td>Status</td>
    				    </tr>
    				    <?php endforeach; ?>
    				</tbody>
    				
				</table>
			</article>
		</div>
		
	</section>
	
	

</article>

