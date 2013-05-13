<div style="float: right; margin-bottom: 30px;">
<select name="center" id="callCenter" rel="tooltip" title="Call Center">
	<option value="ALL">All Centers</option>
	<?php foreach($all_call_centers AS $cc): ?>
	<option value="<?php echo $cc->shortcode; ?>" <?php echo ($cc->shortcode == $center) ? "SELECTED" : ""; ?>><?php echo $cc->title; ?></option>
	<?php endforeach; ?>
</select>
</div>

<article class="full-block clearfix">

	<section>
		<div id="loading_data"><span class="loader red" title="Loading, please wait&#8230;" style="margin-bottom: 20px; margin-right: 30px;"></span> Updating Leaderboard</div>
	</section>

	<section>
		<div id="telesalesList"></div>
	</section>

</article>


<script>
        var reportURL = "<?php echo $url; ?>";

</script>

<?php echo Asset::css('leaderboard/telesales.css'); ?>
<?php echo Asset::js('leaderboard/telesales.js'); ?>