<div style="float: right;">
<input type="text" class="datepicker" name="startdate" id="startdate" rel="tooltip" title="Start Date" value="<?php echo (!is_null($start_date)) ? $start_date : "" ; ?>">
<input type="text" class="datepicker" name="enddate" id="enddate" rel="tooltip" title="End Date" value="<?php echo (!is_null($end_date)) ? $end_date : "" ; ?>">
<a href='#' class="button" id="dateRangeCommission">View Date Range</a>
</div>

<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2>Commission Report</h2>
			
			<nav>
				<ul class="tab-switch">
					<li><a class="default-tab" href="#commission">Commission Report</a></li>
					<li><a href="#invalid">Invalid Payments</a></li>
					<li><a href="#all">All Payments</a></li>
				</ul>
			</nav>
			
		</header>
	</div>
	
	<section>
		<div id="loading_data"><span class="loader red" title="Loading, please wait&#8230;" style="margin-right: 30px;"></span> Loading Commission Report - Please Wait!</div>
	</section>
	
	<section>
	
		<div class="tab default-tab" id="commission">
			<article class="full-block">
				<h3>Commissions</h3>
				
				<table id="commission_table" width="100%"></table>
			</article>
		</div>
		
		<div class="tab" id="invalid">
			<article class="full-block">
				<h3>Invalids</h3>
				
				<table id="invalid_table" width="100%"></table>
			</article>
		</div>
		
		<div class="tab" id="all">
			<article class="full-block">
				<h3>Invalids</h3>
				
				<table id="all_table" width="100%"></table>
			</article>
		</div>

	
	</section>
	
	

</article>

<script>
	$(document).ready(function() {
		
		load_dispositions();
				
	})
	
	var disposition_url = "<?php echo $report_url; ?>";
	
	function load_dispositions()
	{
		$('#loading_data').fadeIn();

		$.ajax({
			"url" : disposition_url,
			"success": function ( json ) {
				if (json['status'] == 'FAIL') {
					alert(json['message']);
				} else {
					
					$('#loading_data').fadeOut();
					
					$('#commission_table').dataTable(json['valids']);
					$('#invalid_table').dataTable(json['invalids']);
					$('#all_table').dataTable(json['all-clients']);
					
					$('#commission_table').css("width","100%");
					$('#invalid_table').css("width","100%");
					$('#all_table').css("width","100%");
				}
			},
			"dataType": "json"
		});
	
	}

	
</script>
