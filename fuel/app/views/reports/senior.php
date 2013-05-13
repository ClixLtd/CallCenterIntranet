<div style="float: right;">

<select name="month" id="month" rel="tooltip" title="Select Month and Year">

    <?php 
    for ($i = 0; $i <= 18; $i++) {
    
        $date = strtotime("-".$i." months");
        echo '<option value="'.date("m-Y", $date).'">'.date("F Y", $date).'</option>';
    
    }
    ?>
    
</select>

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
			<h2>Senior Report</h2>
			
		</header>
	</div>
	
	<section>
		<div id="loading_data"><span class="loader red" title="Loading, please wait&#8230;" style="margin-bottom: 20px; margin-right: 30px;"></span> Loading Report - Please Wait!</div>
	</section>
	
	
	<div class="tab default-tab" id="telesalesListTab">
	
        	<section>
        		<div id="telesalesList"></div>
        	</section>
        	
	</div>
	
</article>

<script>
    var currentCenter = "<?php echo (is_null($center)) ? "ALL" : $center; ?>";
    var reportURL = "<?php echo $url;?>";
</script>

<?php echo Asset::js('reports/senior.js'); ?>
<?php echo Asset::css('reports/senior.css'); ?>