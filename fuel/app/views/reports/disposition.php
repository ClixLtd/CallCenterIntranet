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
			<h2>Disposition Report</h2>
			
			<nav>
				<ul class="tab-switch">
					<li><a class="default-tab" href="#quickview">Quick View</a></li>
					<li><a href="#nocontacts">No Contacts</a></li>
					<li><a href="#referrals">Referrals</a></li>
					<li><a href="#packouts">Pack Outs</a></li>
					<li><a href="#packins">Pack Ins</a></li>
					<!--<li><a href="#payments">Payments</a></li>-->
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
				<h3>Quick View</h3>
				
				<article class="half-block">
				
				<div class="article-container">
					<section>
					<table class="zebra-striped">
						<thead>
							<tr>
								<th></th>
								<th>Count</th>
								<th>Value</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><b>Referrals</b></td>
								<td><div id="referral_count"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
								<td><div id="referral_value"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
							</tr>
							<tr>
								<td><b>Pack Out (DR)</b></td>
								<td><div id="dr_pack_out_count"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
								<td><div id="dr_pack_out_value"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
							</tr>
							<tr>
								<td><b>Pack Out (DMPLUS)</b></td>
								<td><div id="dmplus_pack_out_count"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
								<td><div id="dmplus_pack_out_value"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
							</tr>
							<tr>
								<td><b>Total Pack Out</b></td>
								<td><div id="pack_out_count"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
								<td><div id="pack_out_value"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
							</tr>
							<tr>
								<td><b>Pack In</b></td>
								<td><div id="pack_in_count"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
								<td><div id="pack_in_value"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
							</tr>
							<tr>
								<td><b>Payments</b></td>
								<td><div id="supplier_payments_available"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
								<td><div id="supplier_payments_available"><span class="loader red" title="Loading, please wait&#8230;"></span></div></td>
							</tr>
						</tbody>
					</table>
					</section>
				</div>
				
			</article>

				
			</article>
		</div>
	
		<div class="tab" id="nocontacts">
			<article class="full-block">
				<h3>Referrals</h3>
				
				<table id="nocontacts_table" width="100%"></table>
			</article>
		</div>
	
		<div class="tab" id="referrals">
			<article class="full-block">
				<h3>Referrals</h3>
				
				<table id="referral_table" width="100%"></table>
			</article>
		</div>
	
		<div class="tab" id="packouts">
			<article class="full-block">
				<h3>Referrals</h3>
				<table id="packout_table" width="100%"></table>
			</article>
		</div>
		
		<div class="tab" id="packins">
			<article class="full-block">
				<h3>Referrals</h3>
				<table id="packin_table" width="100%"></table>
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
		
		
		
		var dispositionList = new Array();
		
		dispositionList['No Contact'] = 'Tried to contact but no-one has answered (after a call back)';
		dispositionList['Call Back / Appointment Made'] = 'Arranged Call Back for the specified Date';
		dispositionList['Failed Transfer'] = 'Client was not on phone or hung up before we spoke';
		dispositionList['Referred'] = 'Client was transferred to an agent but the details have not yet been shown';
		dispositionList['Call Accepted'] = 'Client was transferred to an agent the agent is now taking client details';
		dispositionList['Lead Completed'] = 'Packed Out / Sale Agreed';
		dispositionList['Not Interested'] = 'After getting more info from the agent, the client is no longer interested';
		dispositionList['Not struggling'] = 'Can afford monthly payments to creditors, doesn\'t qualify';
		dispositionList['Less than 6 months old'] = 'Debt is less than 6 months old. Had no changes to circumstances, doesn\'t qualify';
		dispositionList['DNQ DR Not interestered DM+'] = 'Didn\'t qualify for DR due to criteria, and doesn\'t want standard DM or PPI';
		dispositionList['Language barrier'] = 'Agent couldn\'t understand client / client couldn’t understand agent';
		dispositionList['In IVA'] = 'In an IVA, agent will have checked if they are signed';
		dispositionList['Bankrupt'] = 'Has been declared bankruptcy';
		dispositionList['Existing Client'] = 'Already a client in one of our group of companies';
		dispositionList['Not Affordable'] = 'Can\'t afford the monthly payments required for any plan';
		dispositionList['Hung Up'] = 'Client hung up during the call with the agent';
		dispositionList['Does not want to affect credit rating'] = 'Doesn\'t want to affect credit rating';
		dispositionList['Does not want to change banks'] = 'Doesn\'t want to change banks, (if they have debt with own bank, they need to change)';
		
		$.ajax({
			"url" : disposition_url,
			"success": function ( json ) {
				if (json['status'] == 'FAIL') {
					alert(json['message']);
					$('#loading_data').fadeOut();
					
				} else {
					
					$('#referral_count').html(json['totals']['referrals']['count']);
					$('#pack_out_count').html(json['totals']['pack_outs']['count']);
					$('#dr_pack_out_count').html(json['totals']['dr_pack_outs']['count']);
					$('#dmplus_pack_out_count').html(json['totals']['dmplus_pack_outs']['count']);
					$('#pack_in_count').html(json['totals']['pack_ins']['count']);
					
					$('#referral_value').html(json['totals']['referrals']['value']);
					$('#pack_out_value').html(json['totals']['pack_outs']['value']);
					$('#dr_pack_out_value').html(json['totals']['dr_pack_outs']['value']);
					$('#dmplus_pack_out_value').html(json['totals']['dmplus_pack_outs']['value']);
					$('#pack_in_value').html(json['totals']['pack_ins']['value']);
					
					$('#packin_table').dataTable(json['pack_ins']);
					$('#packout_table').dataTable(json['pack_outs']);
					$('#referral_table').dataTable(json['referrals']);
					$('#nocontacts_table').dataTable(json['no_contacts']);
					$('#loading_data').fadeOut();
					
					$('#referral_table').css("width","100%");
					$('#packout_table').css("width","100%");
					$('#packin_table').css("width","100%");
					$('#nocontacts_table').css("width","100%");
					
					
					
					
					$('.dispositionName').each(function(index) {
						var $dispo = $(this);
						
						$dispo.attr('rel', 'tooltip');
						
						$dispo.attr('title', dispositionList[$dispo.html()]);
												
					});
					
					$('[rel=tooltip], #main-nav span, .loader').tipsy({gravity:'s', fade:true});
					
					
					$('.no-office').each(function(index) {
						
						var $thisOfficeSelect = $(this);
						var debtSolveID = $(this).attr('id');
					
						$newCenterList = $('<select />');
						
						$newCenterList.append($("<option/>", {
					        value: '-',
					        text: 'Choose a Center...'
					    }));
					    
						<?php foreach($all_call_centers AS $cc): ?>
						$newCenterList.append($("<option/>", {
					        value: '<?php echo $cc->shortcode; ?>',
					        text: '<?php echo $cc->title; ?>'
					    }));
						<?php endforeach; ?>
												
						$newCenterList.change(function() {
							var thisOffice = $(this).val();
							if (confirm("Really change lead " + debtSolveID + " to " + $(this).val() + "?"))
							{
							
								
								$.ajax({
									"url" : '/reports/change_office/'+debtSolveID+'/'+thisOffice+'.json',
									"success": function ( json ) {
										if (json['result'] == 'FAIL') {
											alert(json['message']);
										} else {
											$thisOfficeSelect.html(thisOffice);
										}
									}
								});

							
							}
						});
						
						$thisOfficeSelect.html($newCenterList);
					});
					
				}
			},
			"dataType": "json"
		});
	
	}

	
</script>
