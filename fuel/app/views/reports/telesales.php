<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2>Telesales Report</h2>
		</header>
	</div>
	<section>

		<div id="telesalesList">
			
			
						
		</div>
		
	</section>
	
	

</article>

<script>
    $(function () {
        var reportURL = "<?php echo $url;?>";
    });
</script>

<?php echo Asset::js('reports/telesales.js'); ?>
<?php echo Asset::css('reports/telesales.css'); ?>