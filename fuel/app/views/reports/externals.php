<div style="float: right;">
<form method="post">
<input type="text" class="datepicker" name="startdate" id="startdate" rel="tooltip" title="Start Date" value="<?php echo (!is_null($start_date)) ? $start_date : "" ; ?>">
<input type="text" class="datepicker" name="enddate" id="enddate" rel="tooltip" title="End Date" value="<?php echo (!is_null($end_date)) ? $end_date : "" ; ?>">
<input type="submit" class="button" id="dateRangeExternals" value="View Date Range"><br />
<?php if($view_all): ?>
<select name="center" rel="tooltip" title="Call Center" class="cd-dropdown cd-select" id="center" >
	<option value="-1">All Centers</option>
	<?php foreach($all_call_centers AS $cc): ?>
	<option value="<?php echo $cc->shortcode; ?>" <?php echo ($cc->shortcode == $center) ? "SELECTED" : ""; ?>><?php echo $cc->title; ?></option>
	<?php endforeach; ?>
</select>
<?php endif; ?>
</form>
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
    				        <th>Questions</th>
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
    				        <td><span title="<?php foreach($result[8] as $answer): ?>
    				            <?php echo $answer[0]." : ".$answer[1]; ?><?php echo (strlen($answer[2]) > 1) ? " (".$answer[2].")" : ""; ?><br/>
    				        <?php endforeach; ?>" rel="tooltip"><?php echo $result[7]; ?></span></td>
    				        <td>
    				            <?php
        				        if (!is_null($result[9]))
        				        {
            				        echo Asset::img('externals/'.strtolower($result[9]).'.png', array('rel' => 'tooltip', 'title'=>$result[10]));
        				        }
        				        else
        				        {
            				        echo Asset::img('externals/notyet.png', array('rel' => 'tooltip', 'title'=>$result[10]));
        				        }
        				        ?>
        				        
    				        </td>
    				    </tr>
    				    <?php endforeach; ?>
    				</tbody>
    				
				</table>
			</article>
		</div>
		
	</section>
	
	

</article>

