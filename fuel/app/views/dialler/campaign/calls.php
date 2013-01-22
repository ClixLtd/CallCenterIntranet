<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2>View Campaign Calls</h2>
			
			<nav>
				<ul class="tab-switch">
					<li><select id="timeRange">
						<option value="-">Today</option>
						<option value="10m">10 Minutes</option>
						<option value="30m">30 Minutes</option>
						<option value="1h">1 Hour</option>
						<option value="2h">2 Hours</option>
						<option value="6h">6 Hours</option>
						<option value="12h">12 Hours</option>
						<option value="1d">1 Day</option>
						<option value="1w">1 Week</option>
					</select></li>
				</ul>
			</nav>
		</header>
	</div>
	
	<script>
		var timeLink = "";
		$(function () {
			
			
			$('#timeRange').change(function() {
				timeLink = "/"+$(this).val();
			});
			
		});
	</script>
	
	<section>
	
	
		<article class="full-block">
			<h3>INTERNAL</h3>
			
			<section>
				<div id="gab1LiveChart" class="flotChart" style="width: 100%; height: 300px;"></div>
				<script>
					$(function () {
					
						fillChart();
						
						setInterval(function() {
							fillChart();
						}, 30000)
						
						
						function fillChart()
						{
							var stack = 0, bars = false, lines = true, steps = false;
						
							var options = {
								xaxis: {
							        mode: "time"
							    },
							    yaxis: { min: 0 },
					            series: {
					                stack: stack,
					                
					                lines: { show: lines, fill: true, steps: steps },
					                bars: { show: bars, barWidth: 0.6 }
					            },
					            grid: { hoverable: true, },
					            crosshair: { mode: "x" },
					        };
						    
				            $.ajax({
				                url: "/dialler/campaign/liveview/INTERNAL"+timeLink+".json",
				                method: 'GET'
				            }).done(function(data) {
				            	var inputData = [ ];
				            	
				            	$.each(data, function(key, inputs) {
					            	inputData.push(inputs);
				            	});
				            	
					            $.plot($("#gab1LiveChart"), inputData, options);
				            });
			            }
						
					});
				</script>
			</section>
		</article>
		
		<div class="clear"></div>
	
		<article class="full-block">
			<h3>BURTON-1</h3>
			
			<section>
				<div id="burton1LiveChart" class="flotChart" style="width: 100%; height: 300px;"></div>
				<script>
					$(function () {
					
						fillChart();
						
						setInterval(function() {
							fillChart();
						}, 30000)
						
						
						function fillChart()
						{
							var stack = 0, bars = false, lines = true, steps = false;
						
							var options = {
								xaxis: {
							        mode: "time"
							    },
							    yaxis: { min: 0 },
					            series: {
					                stack: stack,
					                
					                lines: { show: lines, fill: true, steps: steps },
					                bars: { show: bars, barWidth: 0.6 }
					            },
					            grid: { hoverable: true, },
					            crosshair: { mode: "x" },
					        };
						    
				            $.ajax({
				                url: "/dialler/campaign/liveview/BURTON1"+timeLink+".json",
				                method: 'GET'
				            }).done(function(data) {
				            	var inputData = [ ];
				            	
				            	$.each(data, function(key, inputs) {
					            	inputData.push(inputs);
				            	});
				            	
					            $.plot($("#burton1LiveChart"), inputData, options);
				            });
			            }
						
					});
				</script>
			</section>
		</article>
		
		
				
		
		
		<div class="clear"></div>
		

		<article class="half-block">
			<h3>RJ5</h3>
			
			<section>
				<div id="rj5LiveChart" class="flotChart" style="width: 100%; height: 300px;"></div>
				<script>
					$(function () {
					
						
				            	
						fillChart();
						
						setInterval(function() {
							fillChart();
						}, 30000)
						
						
						function fillChart()
						{
							var stack = 0, bars = false, lines = true, steps = false;
						
							var options = {
								xaxis: {
							        mode: "time"
							    },
							    yaxis: { min: 0 },
					            series: {
					                stack: stack,
					                
					                lines: { show: lines, fill: true, steps: steps },
					                bars: { show: bars, barWidth: 0.6 }
					            },
					            grid: { hoverable: true, },
					            crosshair: { mode: "x" },
					        };
						    
				            $.ajax({
				                url: "/dialler/campaign/liveview/UK"+timeLink+".json",
				                method: 'GET'
				            }).done(function(data) {
				            	var inputData = [ ];
				            	
				            	$.each(data, function(key, inputs) {
					            	inputData.push(inputs);
				            	});
				            	

					            $.plot($("#rj5LiveChart"), inputData, options);
					            
				            });
			            }
						
					});
				</script>
			</section>
		</article>

		
		<article class="half-block clearrm">
			<h3>GIPLTD - UKCam</h3>
			
			<section>
				<div id="gbs1LiveChart" class="flotChart" style="width: 100%; height: 300px;"></div>
				<script>
					$(function () {
					
						fillChart();
						
						setInterval(function() {
							fillChart();
						}, 30000)
						
						
						function fillChart()
						{
							var stack = 0, bars = false, lines = true, steps = false;
						
							var options = {
								xaxis: {
							        mode: "time"
							    },
							    yaxis: { min: 0 },
					            series: {
					                stack: stack,
					                
					                lines: { show: lines, fill: true, steps: steps },
					                bars: { show: bars, barWidth: 0.6 }
					            },
					            grid: { hoverable: true, },
					            crosshair: { mode: "x" },
					        };
						    
				            $.ajax({
				                url: "/dialler/campaign/liveview/GIPLTD_UKCam"+timeLink+".json",
				                method: 'GET'
				            }).done(function(data) {
				            	var inputData = [ ];
				            	
				            	$.each(data, function(key, inputs) {
					            	inputData.push(inputs);
				            	});
				            	
					            $.plot($("#gbs1LiveChart"), inputData, options);
				            });
			            }
						
					});
				</script>
			</section>
		</article>
		
		<div class="clear"></div>
		
		<article class="half-block">
			<h3>GAB-LIVE</h3>
			
			<section>
				<div id="gabLiveLiveChart" class="flotChart" style="width: 100%; height: 300px;"></div>
				<script>
					$(function () {
					
						
				            	
						fillChart();
						
						setInterval(function() {
							fillChart();
						}, 30000)
						
						
						function fillChart()
						{
							var stack = 0, bars = false, lines = true, steps = false;
						
							var options = {
								xaxis: {
							        mode: "time"
							    },
							    yaxis: { min: 0 },
					            series: {
					                stack: stack,
					                
					                lines: { show: lines, fill: true, steps: steps },
					                bars: { show: bars, barWidth: 0.6 }
					            },
					            grid: { hoverable: true, },
					            crosshair: { mode: "x" },
					        };
						    
				            $.ajax({
				                url: "/dialler/campaign/liveview/GAB-LIVE"+timeLink+".json",
				                method: 'GET'
				            }).done(function(data) {
				            	var inputData = [ ];
				            	
				            	$.each(data, function(key, inputs) {
					            	inputData.push(inputs);
				            	});
				            	

					            $.plot($("#gabLiveLiveChart"), inputData, options);
					            
				            });
			            }
						
					});
				</script>
			</section>
		</article>

		
		<article class="half-block clearrm">
			<h3>GAB-3</h3>
			
			<section>
				<div id="gab3LiveChart" class="flotChart" style="width: 100%; height: 300px;"></div>
				<script>
					$(function () {
					
						
				            	
						fillChart();
						
						setInterval(function() {
							fillChart();
						}, 30000)
						
						
						function fillChart()
						{
							var stack = 0, bars = false, lines = true, steps = false;
						
							var options = {
								xaxis: {
							        mode: "time"
							    },
							    yaxis: { min: 0 },
					            series: {
					                stack: stack,
					                
					                lines: { show: lines, fill: true, steps: steps },
					                bars: { show: bars, barWidth: 0.6 }
					            },
					            grid: { hoverable: true, },
					            crosshair: { mode: "x" },
					        };
						    
				            $.ajax({
				                url: "/dialler/campaign/liveview/GAB-3"+timeLink+".json",
				                method: 'GET'
				            }).done(function(data) {
				            	var inputData = [ ];
				            	
				            	$.each(data, function(key, inputs) {
					            	inputData.push(inputs);
				            	});
				            	

					            $.plot($("#gab3LiveChart"), inputData, options);
					            
				            });
			            }
						
					});
				</script>
			</section>
		</article>

		


		
		
		
				
	</section>
	
</article>