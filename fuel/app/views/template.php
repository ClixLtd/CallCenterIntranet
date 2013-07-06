<!doctype html>
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
	<title><?php echo $title; ?></title>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<?php echo Asset::js('jquery/jquery-1.5.1.min.js'); ?>
	
	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="apple-touch-icon" href="/apple-touch-icon.png">
	
	<!-- CSS Styles -->
	<?php echo Asset::css('style.css'); ?>
	<?php echo Asset::css('colors.css'); ?>
	<?php echo Asset::css('jquery.tipsy.css'); ?>
	<?php echo Asset::css('jquery-ui.min.css'); ?>
	<?php echo Asset::css('jquery.wysiwyg.css'); ?>
	<?php echo Asset::css('jquery.datatables.css'); ?>
	<?php echo Asset::css('jquery.nyromodal.css'); ?>
	<?php echo Asset::css('jquery.datepicker.css'); ?>
	<?php echo Asset::css('jquery.fileinput.css'); ?>
	<?php echo Asset::css('jquery.fullcalendar.css'); ?>
	<?php echo Asset::css('jquery.visualize.css'); ?>
	<?php echo Asset::css('dropdown.css'); ?>
  
  <?php echo Asset::css('hr.css'); ?>
	
	
	<?php echo Asset::js('jquery/jquery.datatables.js'); ?>
	<?php echo Asset::js('jquery/jquery.datatables.datesort.js'); ?>
	
	<?php echo Asset::js('jquery/jquery.livequery.js'); ?>
	<?php echo Asset::js('jquery/jquery.flot.js'); ?>
	
	
	<?php echo Asset::css('print.css', array('media'=>'print')); ?>
	
	<!-- Google WebFonts -->
	<link href='https://fonts.googleapis.com/css?family=PT+Sans:regular,italic,bold,bolditalic' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Rambla:400,700' rel='stylesheet' type='text/css'>

	<?php echo Asset::js('libs/modernizr-1.7.min.js'); ?>
</head>

<!-- Add class .fixed for fixed layout. You would need also edit CSS file for width -->
<body>


<div id="hideButtonLoading" style="display: none; position: fixed; top: 0px; left: 0px; height: 100%; width: 100%; z-index: 999; background-color: white; background-color: RGBA(255,255,255,0.4);">

    <div id="textArea" style="text-align: center; position:fixed; width: 500px; height: 85px; top: 50%; left: 50%; background-color: #95bcd8; margin-left: -250px; margin-top: -50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; background-color: RGBA(149,188,216,0.5); box-shadow: 0px 0px 5px 1px RGBA(67,98,112,0.6); padding-top: 20px;">
        <?php echo Asset::img('lightspinner.gif'); ?><br />
        <b style="font-size: 18px; line-height: 38px;">Please Wait...</b>
    </div>

</div>

	<!-- Fixed Layout Wrapper -->
	<div class="fixed-wraper">

	<!-- Aside Block -->
	<section role="navigation">
		<!-- Header with logo and headline -->
		<div align="center" id="gablogo">
			<?php echo Html::anchor('/', '<img src="/assets/img/gablogo.png">'); ?>
		</div>
		
		<!-- User Info -->
		<section id="user-info">
			<img src="https://secure.gravatar.com/avatar/<?php echo md5(strtolower(trim($current_user->email))); ?>?d=mm" alt="Gravatar Image">
			<div>
				<?php echo Html::anchor('user/view/'.$current_user->id, $current_user->name); ?>
				<em><?php echo $group_name; ?></em>
				<ul>
					<?php
						$uri = 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($current_user->email))) . '?d=404'; 
						$headers = @get_headers($uri);
						if (!preg_match("|200|", $headers[0])) {
							echo '<li><a class="button-link" href="http://gravatar.com" target="_newWindow" title="Add your e-mail at Gravatar!" rel="tooltip">Add Your Image</a></li>';
						}
						 
					?>
					<li><?php echo Html::anchor('user/logout', 'logout', array('class'=>'button-link')); ?></li>
				</ul>
			</div>
		</section>
		<!-- /User Info -->
		
		<!-- Main Navigation -->
		<nav id="main-nav">
			<ul>
				<li><a href="/" title="" class="dashboard no-submenu">Dashboard</a></li> <!-- Use class .no-submenu to open link instead of a sub menu-->
				<!-- Use class .current to open submenu on page load -->
				
				
				<?php if (Auth::has_access('reports.menu')): ?>
				<li>
					<a href="/reports" title="" class="logs">Reports</a>
					<ul>
						<?php if (Auth::has_access('reports.disposition')): ?><li><?php echo Html::anchor('reports/disposition', 'Disposition Report'); ?></li><?php endif; ?>
						<?php if (Auth::has_access('reports.disposition')): ?><li><?php echo Html::anchor('reports/telesales_report', 'Telesales Report'); ?></li><?php endif; ?>
						<?php if (Auth::has_access('reports.disposition')): ?><li><?php echo Html::anchor('reports/externals', 'Externals Report'); ?></li><?php endif; ?>
						
						<?php if (Auth::has_access('reports.disposition')): ?><li><?php echo Html::anchor('reports/senior_report', 'Senior Report'); ?></li><?php endif; ?>
						<?php if (Auth::has_access('reports.ppi')): ?><li><?php echo Html::anchor('crm/reports/ppi/disposition', 'PPI Disposition Report'); ?></li><?php endif; ?>
						<?php if (Auth::has_access('reports.commission')): ?><li><?php echo Html::anchor('reports/commission', 'Commission Report'); ?></li><?php endif; ?>
						<?php if (Auth::has_access('reports.supplier')): ?><li><?php echo Html::anchor('reports/supplier', 'Supplier Reports'); ?></li><?php endif; ?>
						<?php if (Auth::has_access('reports.best_solutions')): ?><li><?php echo Html::anchor('reports/best_solutions', 'Best Solutions Report'); ?></li><?php endif; ?>

					</ul>
				</li>
				<?php endif; ?>
        
        <!-- Client Area Menu -->
        <!--
        <li>
          <a href="" title="" class="clientarea">Client Area</a>
          <ul>
            <li><?php echo Html::anchor('/clientarea/client_change_details', 'Client Details Change Request');?></li>
            <li><?php echo Html::anchor('/clientarea/messages', 'Messages');?></li>
          </ul>
        </li>
        -->
        <!-- // -->
				
				<?php if (Auth::has_access('ppi.menu')): ?>
				<li>
					<a href="" title="" class="projects">PPI Database</a>
					<ul>
						<?php if (Auth::has_access('ppi.referrals')): ?><li><?php echo Html::anchor('crm/ppi/referrals', 'Referrals'); ?></li><?php endif; ?>
						<?php if (Auth::has_access('ppi.referrals')): ?><li><?php echo Html::anchor('crm/ppi/create', 'Create Referral'); ?></li><?php endif; ?>
					</ul>
				</li>
				<?php endif; ?>
				
				<?php if (Auth::has_access('ppi.menu')): ?>
				<li>
					<a href="" title="" class="projects">Client Database</a>
					<ul>
						<?php if (Auth::has_access('ppi.menu')): ?><li><?php echo Html::anchor('crm', 'Find Client'); ?></li><?php endif; ?>
						<?php if (Auth::has_access('ppi.menu')): ?><li><?php echo Html::anchor('crm/reports/ppi/chase', 'Client Chase List'); ?></li><?php endif; ?>
						<?php if (Auth::has_access('ppi.menu')): ?><li><?php echo Html::anchor('crm/reports/ppi/claim_report', 'PPI Claim Report'); ?></li><?php endif; ?>
						<?php if (Auth::has_access('ppi.admin')): ?><li><?php echo Html::anchor('crm/creditor/add', 'Add Creditor'); ?></li><?php endif; ?>
					</ul>
				</li>
				<?php endif; ?>
				
				<?php if (Auth::has_access('database.menu')): ?>
				<li>
					<a href="" title="" class="projects">Database</a>
					<ul>
						<?php if (Auth::has_access('database.servers')): ?><li><?php echo Html::anchor('database/server', 'Servers'); ?></li><?php endif; ?>
						<?php if (Auth::has_access('database.queries')): ?><li><?php echo Html::anchor('database/query', 'Queries'); ?></li><?php endif; ?>
					</ul>
				</li>
				<?php endif; ?>
				
				<?php if (Auth::has_access('data_suppliers.menu')): ?>
				<li class="current">
					<a href="/reports" title="" class="logs">Data Suppliers</a>
					<ul>
						<?php if (Auth::has_access('data_suppliers.view')): ?><li><?php echo Html::anchor('data/supplier/index', 'View Suppliers'); ?></li><?php endif; ?>
						<?php if (Auth::has_access('data_suppliers.lists')): ?><li><?php echo Html::anchor('data/supplier/list/index', 'Data Lists'); ?></li><?php endif; ?>
					</ul>
				</li>
				<?php endif; ?>
				
				<?php if (Auth::has_access('news.menu')): ?>
				<li>
					<a href="/reports" title="" class="logs">Latest News</a>
					<ul>
						<?php if (Auth::has_access('news.create')): ?><li><?php echo Html::anchor('news/create', 'Add News'); ?></li><?php endif; ?>
					</ul>
				</li>
				<?php endif; ?>
				
				<?php if (Auth::has_access('support.menu')): ?>
				<li>
					<a href="/reports" title="" class="logs">Support</a>
					<ul>
						<?php if (Auth::has_access('support.heartbeat_monitor')): ?><li><?php echo Html::anchor('statistics/servers', 'Heartbeat Monitor'); ?></li><?php endif; ?>
						<?php if (Auth::has_access('support.knowledge_base')): ?><li><?php echo Html::anchor('ss', 'Knowledge Base'); ?></li><?php endif; ?>
						<?php if (Auth::has_access('support.create_ticket')): ?><li><?php echo Html::anchor('help/ticket/create', 'Create Ticket'); ?></li><?php endif; ?>
						<?php if (Auth::has_access('support.view_tickets')): ?><li><?php echo Html::anchor('help/ticket/index', 'View Tickets'); ?></li><?php endif; ?>
						
						
						<?php if (Auth::has_access('support.manage_topics')): ?><li><?php echo Html::anchor('help/topic', 'Manage Topics'); ?></li><?php endif; ?>
					</ul>
				</li>
				<?php endif; ?>
				
				<?php if (Auth::has_access('cal.menu')): ?>
				<li>
					<a href="/users" title="" class="logs">Calendar</a>
					<ul>
						<?php if (Auth::has_access('cal.view')): ?><li><?php echo Html::anchor('calendar/view', 'View Calendar'); ?></li><?php endif; ?>
					</ul>
				</li>
				<?php endif; ?>
				
				<?php if (Auth::has_access('user.menu')): ?>
				<li>
					<a href="/users" title="" class="logs">Staff</a>
					<ul>
						<?php if (Auth::has_access('user.view')): ?><li><?php echo Html::anchor('staff', 'Staff List'); ?></li><?php endif; ?>
					</ul>
				</li>
				<?php endif; ?>

				<li>
					<a href="/leaderboard" title="" class="logs">Leaderboards</a>
					<ul>
						<li><?php echo Html::anchor('leaderboard/telesales', 'Telesales'); ?></li>
						<li><?php echo Html::anchor('leaderboard/senior', 'Seniors'); ?></li>
					</ul>
				</li>
				
			</ul>
		</nav>
		<!-- /Main Navigation -->
		
		<!-- Sidebar -->
		<!-- /Sidebar -->
		
	</section>
	<!-- /Aside Block -->
	
	<!-- Main Content -->
	<section role="main">

		
		<!-- Breadcumbs -->
		<?php echo Breadcrumb::create_links(); ?>
		<!-- /Breadcumbs -->
		
		<?php if (Session::get_flash('fail')): ?>
		<div class="notification error">
			<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
			<p>
			<?php echo implode('</p><p>', e((array) Session::get_flash('fail'))); ?>
			</p>
		</div>
		<?php endif; ?>
		
		<?php if (Session::get_flash('success')): ?>
		<div class="notification success">
			<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
			<p>
			<?php echo implode('</p><p>', e((array) Session::get_flash('success'))); ?>
			</p>
		</div>
		<?php endif; ?>
	
		<?php echo $content; ?>
		
		<?php if (Auth::has_access('user.view')): ?>
		<div>
			<p style="color: silver; font-weight: bold; text-align: right;">Version: <?php echo e(Fuel::VERSION); ?> - Render Time: {exec_time}s - Memory Use: {mem_usage}mb</p>
		</div>
		<?php endif; ?>
		
	</section>
	<!-- /Main Content -->
	
	</div>
	
	
	<!-- /Fixed Layout Wrapper -->

	<!-- JS Libs at the end for faster loading -->
	<?php echo Asset::js('libs/selectivizr.js'); ?>
	<?php echo Asset::js('jquery/jquery.nyromodal.js'); ?>
	<?php echo Asset::js('jquery/jquery.tipsy.js'); ?>
	<?php echo Asset::js('jquery/jquery.wysiwyg.js'); ?>
	<?php echo Asset::js('jquery/jquery.wysiwyg.link.js'); ?>
	<?php echo Asset::js('jquery/jquery-ui.min.js'); ?>
	<?php echo Asset::js('jquery/jquery.datepicker.js'); ?>
	<?php echo Asset::js('jquery/jquery.timepicker.js'); ?>
	<?php echo Asset::js('jquery/jquery.fileinput.js'); ?>
	<?php echo Asset::js('jquery/jquery.fullcalendar.min.js'); ?>
	<?php echo Asset::js('jquery/excanvas.js'); ?>
	<?php echo Asset::js('jquery/jquery.visualize.js'); ?>
	<?php echo Asset::js('jquery/jquery.visualize.tooltip.js'); ?>
	<?php echo Asset::js('jquery/jquery.dropdown.js'); ?>
	<?php echo Asset::js('script.js'); ?>
	
</body>
</html>