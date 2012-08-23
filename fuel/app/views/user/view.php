<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2>User List</h2>
		</header>
	</div>
	
	

	
	<section>
	
	
		<article class="full-block">
		
			<table id="user_view"></table>
			
			<script>
				$(document).ready(function() {
					$.ajax({
						"url" : "/user/view.json",
						"success": function ( json ) {
							if (json['error']) {
								alert(json['error']);
							} else {
								$('#user_view').dataTable(json)
							}
						},
						"dataType": "json"
					});
				})
			</script>
			
		</article>
	
	
	</section>
	
	

</article>