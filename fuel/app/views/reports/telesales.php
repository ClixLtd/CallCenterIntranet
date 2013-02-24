<div style="float: right;">
<?php if($view_all): ?>
<select name="center" id="callCenter" rel="tooltip" title="Call Center">
	<option value="ALL">All Centers</option>
	<?php foreach($all_call_centers AS $cc): ?>
	<option value="<?php echo $cc->shortcode; ?>" <?php echo ($cc->shortcode == $center) ? "SELECTED" : ""; ?>><?php echo $cc->title; ?></option>
	<?php endforeach; ?>
</select>
<?php endif; ?>
</div>

<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2>Telesales Report</h2>
			
		</header>
	</div>
	
	<section>
		<div id="loading_data"><span class="loader red" title="Loading, please wait&#8230;" style="margin-bottom: 20px; margin-right: 30px;"></span> Loading Report - Please Wait!</div>
	</section>
	
	<section>
		<div id="telesalesList">
    		
    		
    		<ul class="allTelesales">
        		<li>
            		<ul class="alt1">
                		<li>asdasd</li>
                		<li>asdasd</li>
                		
                		<li class="subDetails">
                    		
                        		<ul>
                            		<li>
                                		<ul class="titles">
                                    		<li>Name</li>
                                    		<li>Leadpool ID</li>
                                    		<li>Lead Source</li>
                                    		<li>Result</li>
                                    		<li>DI</li>
                                    		<li>Referred</li>
                                    		<li>DI</li>
                                    		<li>Last Contact</li>
                                    		<li>Call Back</li>
                                		</ul>
                            		</li>
                            		<li>
                                		<ul class="alt2">
                                    		<li>Name</li>
                                    		<li>Leadpool ID</li>
                                    		<li>Lead Source</li>
                                    		<li>Result</li>
                                    		<li>DI</li>
                                    		<li>Referred</li>
                                    		<li>DI</li>
                                    		<li>Last Contact</li>
                                    		<li>Call Back</li>
                                		</ul>
                            		</li>
                            		<li>
                                		<ul class="alt2">
                                    		<li>Name</li>
                                    		<li>Leadpool ID</li>
                                    		<li>Lead Source</li>
                                    		<li>Result</li>
                                    		<li>DI</li>
                                    		<li>Referred</li>
                                    		<li>DI</li>
                                    		<li>Last Contact</li>
                                    		<li>Call Back</li>
                                		</ul>
                            		</li>
                            		<li>
                                		<ul class="alt2">
                                    		<li>Name</li>
                                    		<li>Leadpool ID</li>
                                    		<li>Lead Source</li>
                                    		<li>Result</li>
                                    		<li>DI</li>
                                    		<li>Referred</li>
                                    		<li>DI</li>
                                    		<li>Last Contact</li>
                                    		<li>Call Back</li>
                                		</ul>
                            		</li>
                            		<li>
                                		<ul class="alt2">
                                    		<li>Name</li>
                                    		<li>Leadpool ID</li>
                                    		<li>Lead Source</li>
                                    		<li>Result</li>
                                    		<li>DI</li>
                                    		<li>Referred</li>
                                    		<li>DI</li>
                                    		<li>Last Contact</li>
                                    		<li>Call Back</li>
                                		</ul>
                            		</li>
                                </ul>
                        		
                    		
                		</li>
                		
                		
                		
            		</ul>
        		</li>
        		<li>
            		<ul class="alt2">
                		<li>asdasd</li>
                		<li>asdasd</li>
                		
                		<li class="subDetails">
                    		<div>
                    		
                        		safasd
                    		
                    		</div>
                		</li>
                		
            		</ul>
        		</li>
        		<li>
            		<ul class="alt1">
                		<li>asdasd</li>
                		<li>asdasd</li>
            		</ul>
        		</li>
        		<li>
            		<ul class="alt2">
                		<li>asdasd</li>
                		<li>asdasd</li>
            		</ul>
        		</li>
        		<li>
            		<ul class="alt1">
                		<li>asdasd</li>
                		<li>asdasd</li>
            		</ul>
        		</li>
    		</ul>
    		
    		
		</div>
	</section>
	
	

</article>

<script>
    var reportURL = "<?php echo $url;?>";
</script>

<?php echo Asset::js('reports/telesales.js'); ?>
<?php echo Asset::css('reports/telesales.css'); ?>