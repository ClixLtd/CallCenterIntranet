<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2>View Server Statistics</h2>
			
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
			<h3>Server Load</h3>
			
			<section>
				<div id="serverLoad" class="flotChart" style="width: 100%; height: 300px;"></div>
				<script>
					$(function () {
					
						fillChart();
						
						setInterval(function() {
							fillChart();
						}, 15000)
						
						
						function fillChart()
						{
							var stack = 0, bars = false, lines = true, steps = true;
						
							var options = {
								xaxis: {
							        mode: "time"
							    },
							    yaxis: { min: 0 },
					            series: {
					                stack: stack,
					                
					                lines: { show: lines, fill: false, steps: steps, fillColor: null },
					                bars: { show: bars, barWidth: 0.6, fill: true, fillColor: { colors: [  { opacity: 0.1}, {opacity: 1 } ] } }
					            },
					            grid: { hoverable: true, },
					            crosshair: { mode: "x" },
					            legend: {
					               show: true,
    					           position: "nw",
					            },
					        };
						    
				            $.ajax({
				                url: "/heartbeat/server_stats/load"+timeLink+".json",
				                method: 'GET'
				            }).done(function(data) {
				            	var inputData = [ ];
				            	
				            	$.each(data, function(key, inputs) {
					            	inputData.push(inputs);
				            	});
				            	
					            $.plot($("#serverLoad"), inputData, options);
				            });
			            }
						
					});
				</script>
			</section>
		</article>
		
		<div class="clear"></div>
		
		<article class="full-block">
			<h3>Used Memory</h3>
			
			<section>
				<div id="freeMem" class="flotChart" style="width: 100%; height: 300px;"></div>
				<script>
					$(function () {
					
						fillChart();
						
						setInterval(function() {
							fillChart();
						}, 15000)
						
						
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
					                
					                lines: { show: lines, fill: false, steps: steps, fillColor: null },
					                bars: { show: bars, barWidth: 0.6, fill: true, fillColor: { colors: [  { opacity: 0.1}, {opacity: 1 } ] } }
					            },
					            grid: { hoverable: true, },
					            crosshair: { mode: "x" },
					            legend: {
					               show: true,
    					           position: "nw",
					            },
					        };
						    
				            $.ajax({
				                url: "/heartbeat/server_stats/memused"+timeLink+".json",
				                method: 'GET'
				            }).done(function(data) {
				            	var inputData = [ ];
				            	
				            	$.each(data, function(key, inputs) {
					            	inputData.push(inputs);
				            	});
				            	
					            $.plot($("#freeMem"), inputData, options);
				            });
			            }
						
					});
				</script>
			</section>
		</article>
		
		<div class="clear"></div>
		
		<article class="half-block">
			<h3>Drive Space Free</h3>
			
			<section>
				<div id="driveSpace" class="flotChart" style="width: 100%; height: 300px;"></div>
				<script>
					$(function () {
					
						fillChart();
						
						setInterval(function() {
							fillChart();
						}, 15000)
						
						
						function fillChart()
						{
							var stack = 0, bars = false, lines = true, steps = true;
						
							var options = {
								xaxis: {
							        mode: "time"
							    },
							    yaxis: { min: 0 },
					            series: {
					                stack: stack,
					                
					                lines: { show: lines, fill: false, steps: steps, fillColor: null },
					                bars: { show: bars, barWidth: 0.6 }
					            },
					            grid: { hoverable: true, },
					            crosshair: { mode: "x" },
					            legend: {
					               show: true,
    					           position: "nw",
					            },
					        };
						    
				            $.ajax({
				                url: "/heartbeat/server_stats/harddisk"+timeLink+".json",
				                method: 'GET'
				            }).done(function(data) {
				            	var inputData = [ ];
				            	
				            	$.each(data, function(key, inputs) {
					            	inputData.push(inputs);
				            	});
				            	
					            $.plot($("#driveSpace"), inputData, options);
				            });
			            }
						
					});
				</script>
			</section>
		</article>
		

		<article class="half-block clearrm">
			<h3>CPU Useage</h3>
			
			<section>
				<div id="cpuUseage" class="flotChart" style="width: 100%; height: 300px;"></div>
				<script>
					$(function () {
					
						fillChart();
						
						setInterval(function() {
							fillChart();
						}, 15000)
						
						
						function fillChart()
						{
							var stack = 0, bars = false, lines = true, steps = true;
						
							var options = {
								xaxis: {
							        mode: "time"
							    },
							    yaxis: { min: 0 },
					            series: {
					                stack: stack,
					                
					                lines: { show: lines, fill: false, steps: steps, fillColor: null },
					                bars: { show: bars, barWidth: 0.6 }
					            },
					            grid: { hoverable: true, },
					            crosshair: { mode: "x" },
					            legend: {
					               show: true,
    					           position: "nw",
					            },
					        };
						    
				            $.ajax({
				                url: "/heartbeat/server_stats/cpu"+timeLink+".json",
				                method: 'GET'
				            }).done(function(data) {
				            	var inputData = [ ];
				            	
				            	$.each(data, function(key, inputs) {
					            	inputData.push(inputs);
				            	});
				            	
					            $.plot($("#cpuUseage"), inputData, options);
				            });
			            }
						
					});
				</script>
			</section>
		</article>
		
		
				
	</section>
	
</article>