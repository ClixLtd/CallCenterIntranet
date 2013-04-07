<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2>Agent Report</h2>
		</header>
	</div>
	
	<section>
		<div class="tab default-tab" id="quickview">
			
			
			<article class="full-block agentReportStep">
    			
    			<h3>Step One</h3>
    			<h4>Choose the agent or group of agents you wish to view</h4>
				
				<article class="full-block">
				
				    <div class="article-container">
				        
				        <article class="half-block">
				            <div class="agentList">
				                <?php foreach ($all_active_agents AS $agent): ?>
				                    <div style="line-height: 20px !important;"><input type="checkbox" style="height: 22px; margin-right: 10px;"> <?php echo $agent->first_name . " " . $agent->last_name; ?></div>
				                <?php endforeach; ?>
				            </div>
				        </article>
				        
				        <article class="half-block clearrm">
				            asdasd
				        </article>
				        
				    </div>
				    
				</article>
    			
			</article>
			
			
			
			<article class="full-block">
    			
    			<h3>Step Two</h3>
    			<h4>Choose the agent or group of agents you wish to compare against</h4>
				
				<article class="full-block">
				
				    <div class="article-container">
				    
				    </div>
				</article>
    			
			</article>
			
			
			
		</div>
	</section>
</article>