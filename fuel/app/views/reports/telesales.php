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

		<div id="telesalesList"></div>
		
	</section>
	
	

</article>

<script>
    var reportURL = "<?php echo $url;?>";
</script>

<?php echo Asset::js('reports/telesales.js'); ?>
<?php echo Asset::css('reports/telesales.css'); ?>