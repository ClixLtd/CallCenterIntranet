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

	<script src="/assets/js/jquery/jquery-1.5.1.min.js" type="text/javascript"></script>
	
	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="apple-touch-icon" href="/apple-touch-icon.png">

	<link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

	<!-- CSS Styles -->
	<link href="/assets/css/style.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/colors.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/jquery.tipsy.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/jquery-ui.min.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/jquery.wysiwyg.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/jquery.datatables.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/jquery.nyromodal.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/jquery.datepicker.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/jquery.fileinput.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/jquery.fullcalendar.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/jquery.visualize.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/dropdown.css" rel="stylesheet" type="text/css" />

	<link href="/assets/css/hr.css" rel="stylesheet" type="text/css" />

	<script src="/assets/js/jquery/jquery.datatables.js" type="text/javascript"></script>
	<script src="/assets/js/jquery/jquery.datatables.datesort.js" type="text/javascript"></script>
	<script src="/assets/js/jquery/jquery.livequery.js" type="text/javascript"></script>
	<script src="/assets/js/jquery/jquery.flot.js" type="text/javascript"></script>
	<script src="/assets/js/jquery/jquery.flot.pie.js" type="text/javascript"></script

	<link href="/assets/css/print.css" type="text/css" rel="stylesheet" media="print"/>
	
	<!-- Google WebFonts -->
	<link href='https://fonts.googleapis.com/css?family=PT+Sans:regular,italic,bold,bolditalic' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Rambla:400,700' rel='stylesheet' type='text/css'>

	<script src="/assets/js/libs/modernizr-1.7.min.js" type="text/javascript"></script>


</head>

<!-- Add class .fixed for fixed layout. You would need also edit CSS file for width -->
<body>


<div id="hideButtonLoading" style="display: none; position: fixed; top: 0px; left: 0px; height: 100%; width: 100%; z-index: 999; background-color: white; background-color: RGBA(255,255,255,0.4);">

    <div id="textArea" style="text-align: center; position:fixed; width: 500px; height: 85px; top: 50%; left: 50%; background-color: #95bcd8; margin-left: -250px; margin-top: -50px; border-radius: 20px; -webkit-border-radius: 20px; -moz-border-radius: 20px; background-color: RGBA(149,188,216,0.5); box-shadow: 0px 0px 5px 1px RGBA(67,98,112,0.6); padding-top: 20px;">
		<img src="/assets/img/lightspinner.gif" /><br />
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

				<li><a href="/data/add" class="logs">Upload Data</a></li>
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
			<p style="color: silver; font-weight: bold; text-align: right;">Intranet: <?php echo exec('git describe --tags --long'); ?> (<?php echo exec('git rev-parse --abbrev-ref HEAD'); ?>) - Fuel: <?php echo e(Fuel::VERSION); ?> - Render Time: {exec_time}s - Memory Use: {mem_usage}mb</p>
		</div>
		<?php endif; ?>
		
	</section>
	<!-- /Main Content -->
	
	</div>
	
	
	<!-- /Fixed Layout Wrapper -->

	<!-- JS Libs at the end for faster loading -->
	<script src="/assets/js/libs/selectivizr.js" type="text/javascript"></script>
	<script src="/assets/js/jquery/jquery.nyromodal.js" type="text/javascript"></script>
	<script src="/assets/js/jquery/jquery.tipsy.js" type="text/javascript"></script>
	<script src="/assets/js/jquery/jquery.wysiwyg.js" type="text/javascript"></script>
	<script src="/assets/js/jquery/jquery.wysiwyg.link.js" type="text/javascript"></script>
	<script src="/assets/js/jquery/jquery-ui.min.js" type="text/javascript"></script>
	<script src="/assets/js/jquery/jquery.datepicker.js" type="text/javascript"></script>
	<script src="/assets/js/jquery/jquery.timepicker.js" type="text/javascript"></script>
	<script src="/assets/js/jquery/jquery.fileinput.js" type="text/javascript"></script>
	<script src="/assets/js/jquery/jquery.fullcalendar.min.js" type="text/javascript"></script>
	<script src="/assets/js/jquery/excanvas.js" type="text/javascript"></script>
	<script src="/assets/js/jquery/jquery.visualize.js" type="text/javascript"></script>
	<script src="/assets/js/jquery/jquery.visualize.tooltip.js" type="text/javascript"></script>
	<script src="/assets/js/jquery/jquery.dropdown.js" type="text/javascript"></script>
	<script src="/assets/js/script.js" type="text/javascript"></script>


<!--<script type="text/javascript" src="https://s3.amazonaws.com/assets.freshdesk.com/widget/freshwidget.js"></script>-->
<!--<script type="text/javascript">-->
<!--	FreshWidget.init("", {"queryString": "&widgetType=popup", "widgetType": "popup", "buttonType": "text", "buttonText": "Get Help", "buttonColor": "white", "buttonBg": -->
<!--"#ff6d14", "alignment": "2", "offset": "235px", "formHeight": "600px", "url": "http://ticket.clix.co.uk"} );-->
<!--</script>-->
	
</body>
</html>
