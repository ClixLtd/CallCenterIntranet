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
			
			<nav>
				<ul class="tab-switch">
					<li><a class="default-tab" href="#telesalesList">Full Report</a></li>
					<li><a href="#centerSettings">Center Settings</a></li>
				</ul>
			</nav>
			
		</header>
	</div>
	
	<section>
		<div id="loading_data"><span class="loader red" title="Loading, please wait&#8230;" style="margin-bottom: 20px; margin-right: 30px;"></span> Loading Report - Please Wait!</div>
	</section>
	
	
	<div class="tab default-tab" id="telesalesList">
	   <article class="full-block">
	
        	<section>
        		<div id="telesalesList"></div>
        	</section>
	   </article>
	</div>
	
	<div class="tab" id="centerSettings">
	   <article class="full-block">
	
        	<section>
        		<form>
            		<dl>
        				<dt>
        					<label>Points Per Referral</label>
        				</dt>
        				<dd>
        					<input type="text" class="small" name="referral_points" placeholder="Referral Points">
        				</dd>
        				<dt>
        					<label>Points Per Pack Out</label>
        				</dt>
        				<dd>
        					<input type="text" class="small" name="pack_out_points" placeholder="Pack Out Points">
        				</dd>
        				<dt>
        					<label>Points per Pound of DI</label>
        				</dt>
        				<dd>
        					<input type="text" class="small" name="di_pound_point" placeholder="Points per Pound">
        				</dd>
        				<dt>
        					<label>Commission per Pack Out (£)</label>
        				</dt>
        				<dd>
        					<input type="text" class="small" name="pack_out_commission" placeholder="Pack Out Commission">
        				</dd>
        				<dt>
        					<label>Special Bonus for Pack Out (£)</label>
        				</dt>
        				<dd>
        					<input type="text" class="small" name="pack_out_bonus" placeholder="Pack Out Bonus">
        				</dd>
        				<dt>
        					<label>Commission for First Payment (%)</label>
        				</dt>
        				<dd>
        					<input type="text" class="small" name="payment_percentage" placeholder="First Payment Commission">
        				</dd>
            		</dl>
        		</form>
        	</section>
	   </article>
	</div>
	

</article>

<script>
    var reportURL = "<?php echo $url;?>";
</script>

<?php echo Asset::js('reports/telesales.js'); ?>
<?php echo Asset::css('reports/telesales.css'); ?>