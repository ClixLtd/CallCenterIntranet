<article class="full-block clearfix">

	<div class="article-container">
		<header>
			<h2>Data Importer</h2>
			
		</header>
	
	
		<section>
		
			<div class="sidetabs">
			
				<nav class="sidetab-switch">
					<ul>
						<li><a class="default-sidetab" href="#latestNews">Latest News</a></li>
						<?php if (!is_null($invalid_logins)): ?>
						<li><a href="#invalidLogins">Invalid Logins</a></li>
						<?php endif; ?>
						<!-- <li><a href="#sidetab5">Support Tickets</a></li> -->
					</ul>
				</nav>
			
				<div class="sidetab default-sidetab" id="latestNews">
					<h3>Latest News</h3>
					
						<ul class="logs">
							<?php if (!is_null($latest_news)): ?>
							<?php foreach($latest_news AS $news): ?>
							<li>
								<span class="logs-timestamp"><?php echo date("F jS, Y",$news->created_at); ?></span>
								<h4><a class="logs-event" href="#"><?php echo $news->title; ?></a></h4>
								<p><?php echo nl2br($news->article); ?></p>
								<em class="logs-meta">Posted by <a href="#"><?php echo $news->user->name; ?></a></em>
							</li>
							<?php endforeach; ?>
							<?php else: ?>
							<div>
								No News at this time!
							</div>
							<?php endif; ?>
						</ul>
				
				</div>
				
				<?php if (!is_null($invalid_logins)): ?>
				
				<div class="sidetab" id="invalidLogins">
					<h3>Invalid Logins</h3>
					
						<ul class="logs">
							<?php foreach($invalid_logins AS $invalid_login): ?>
							<li class="bomb">
								<span class="logs-timestamp"><?php echo date("F jS, Y",$invalid_login->login_time); ?></span>
								<h4><a class="logs-event" href="#">Invalid Login from <?php echo $invalid_login->ip_address; ?></a></h4>
								<p>Someone tried to login on your account at <?php echo date("H:i",$invalid_login->login_time); ?> on <?php echo date("F jS, Y",$invalid_login->login_time); ?> with username '<?php echo $invalid_login->attempted_login; ?>' <br />If this was you or a one off then there is probably no need to worry. If there are multiples you are not aware of, please inform support!</p>
							</li>
							<?php endforeach; ?>
						</ul>
				
				</div>
				
				<?php endif; ?>
				
				<!--
				<div class="sidetab" id="sidetab5">
					<h3>Support Tickets</h3>
					
						<ul class="logs">
							<li>
								<span class="logs-timestamp">May 28, 2011</span>
								<h4><a class="logs-event" href="#">System Update #112563</a></h4>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis. Phasellus aliquam malesuada blandit.</p>
								<em class="logs-meta">Posted by <a href="#">Administrator</a></em>
							</li>
						</ul>
				
				</div>
				-->
				
			</div>
			
		</section>
		
	</div>
	
</article>

