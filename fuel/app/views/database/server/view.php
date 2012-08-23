<article class="half-block clearrm">

	<div class="article-container">
		<header>
			<h2>Viewing <?php echo $database_server->title; ?></h2>
			
			<nav>
				<ul class="button-switch">
					<li><?php echo Html::anchor('database/server/edit/'.$database_server->id, 'Edit', array('class' => 'button')); ?></li>
					<li><?php echo Html::anchor('database/server', 'Back', array('class' => 'button')); ?></li>
				</ul>
			</nav>
		</header>
	</div>
	
	<section>


		<p>
			<strong>Title:</strong>
			<?php echo $database_server->title; ?></p>
		<p>
			<strong>Hostname:</strong>
			<?php echo $database_server->hostname; ?></p>
		<p>
			<strong>Username:</strong>
			<?php echo $database_server->username; ?></p>
		<p>
			<strong>Password:</strong>
			<?php echo $database_server->password; ?></p>
	
	</section>

</article>

<article class="half-block clearrm">

</article>