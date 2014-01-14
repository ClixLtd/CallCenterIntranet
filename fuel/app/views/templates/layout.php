<!DOCTYPE HTML>
<html lang="en-US">
<head>

    <meta charset="UTF-8">
    <title>Beoro Admin Template v1.2</title>
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link rel="icon" type="image/ico" href="favicon.ico">

    <!-- common stylesheets-->
    <!-- bootstrap framework css -->
    <?php echo Asset::css('bootstrap.min.css'); ?>
    <?php echo Asset::css('bootstrap-responsive.min.css'); ?>
    <!-- iconSweet2 icon pack (16x16) -->
    <?php echo Asset::css('../img/icsw2_16/icsw2_16.css'); ?>
    <!-- splashy icon pack -->
    <?php echo Asset::css('../img/splashy/splashy.css'); ?>
    <!-- flag icons -->
    <?php echo Asset::css('../img/flags/flags.css'); ?>
    <!-- power tooltips -->
    <?php echo Asset::css('../js/lib/powertip/jquery.powertip.css'); ?>
    <!-- google web fonts -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Abel">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300">

    <!-- aditional stylesheets -->
    <!-- colorbox -->
    <?php echo Asset::css('../js/lib/colorbox/colorbox.css'); ?>
    <!--fullcalendar -->
    <?php echo Asset::css('../js/lib/fullcalendar/fullcalendar_beoro.css'); ?>

    <?php echo Asset::css('../js/lib/datatables/css/datatables_beoro.css'); ?>
    <?php echo Asset::css('../js/lib/datatables/extras/TableTools/media/css/TableTools.css'); ?>

    <!-- main stylesheet -->
    <?php echo Asset::css('beoro.css'); ?>

    <!--[if lte IE 8]><?php echo Asset::css('ie8.css'); ?><![endif]-->
    <!--[if IE 9]><?php echo Asset::css('ie9.css'); ?><![endif]-->

    <!--[if lt IE 9]>
    <?php echo Asset::js('ie/html5shiv.min.js'); ?>
    <?php echo Asset::js('ie/respond.min.js'); ?>
    <?php echo Asset::js('lib/flot-charts/excanvas.min.js'); ?>
    <![endif]-->

</head>
<body class="bg_d">
<!-- main wrapper (without footer) -->
<div class="main-wrapper">
<!-- top bar -->
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <div class="pull-right top-search">
                <form action="" >
                    <input type="text" name="q" id="q-main">
                    <button class="btn"><i class="icon-search"></i></button>
                </form>
            </div>
            <div id="fade-menu" class="pull-left">
                <ul class="clearfix" id="mobile-nav">
                    <li>
                        <a href="javascript:void(0)">Forms</a>
                        <ul>
                            <li>
                                <a href="form_elements.html">Form elements</a>
                            </li>
                            <li>
                                <a href="form_validation.html">Form validation</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0)">Components</a>
                        <ul>
                            <li>
                                <a href="calendar.html">Calendar</a>
                            </li>
                            <li>
                                <a href="charts.html">Charts</a>
                            </li>
                            <li>
                                <a href="contact_list.html">Contact List</a>
                            </li>
                            <li>
                                <a href="datatables.html">Datatables</a>
                            </li>
                            <li>
                                <a href="editable_elements.html">Editable Elements</a>
                            </li>
                            <li>
                                <a href="file_manager.html">File manager</a>
                            </li>
                            <li>
                                <a href="gallery.html">Gallery</a>
                            </li>
                            <li>
                                <a href="gmaps.html">Google Maps</a>
                            </li>
                            <li>
                                <a href="#">Tables</a>
                                <ul>
                                    <li><a href="tables_regular.html">Regular Tables</a></li>
                                    <li><a href="table_stacking.html">Stacking Table</a></li>
                                    <li><a href="table_examples.html">Table examples</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="wizard.html">Wizard</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0)">UI Elements</a>
                        <ul>
                            <li><a href="alerts_buttons.html">Alerts, Buttons</a></li>
                            <li><a href="grid.html">Grid</a></li>
                            <li><a href="icons.html">Icons</a></li>
                            <li><a href="js_grid.html">JS Grid</a></li>
                            <li>
                                <a href="notifications.html">Notifications</a>
                            </li>
                            <li><a href="tabs_accordions.html">Tabs, Accordions</a></li>
                            <li><a href="tooltips_popovers.html">Tooltips, Popovers</a></li>
                            <li><a href="typography.html">Typography</a></li>
                            <li><a href="widgets.html">Widgets</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0)">Other pages</a>
                        <ul>
                            <li><a href="ajax_content.html">Ajax content</a></li>
                            <li><a href="blank.html">Blank page</a></li>
                            <li><a href="blog_page.html">Blog page</a></li>
                            <li><a href="blog_page_single.html">Blog page (single)</a></li>
                            <li><a href="chat.html">Chat</a></li>
                            <li><a href="error_404.html">Error 404</a></li>
                            <li><a href="help_faq.html">Help/Faq</a></li>
                            <li><a href="invoices.html">Invoices</a></li>
                            <li><a href="login.html">Login Page</a></li>
                            <li><a href="mailbox.html">Mailbox</a></li>
                            <li><a href="user_profile.html">User profile</a></li>
                            <li><a href="settings.html">Site Settings</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0)">Sub-menu</a>
                        <ul>
                            <li><a href="#">Section 1</a></li>
                            <li><a href="#">Section 2</a></li>
                            <li><a href="#">Section 3</a></li>
                            <li>
                                <a href="#">Section 4</a>
                                <ul>
                                    <li><a href="#">Section 4.1</a></li>
                                    <li><a href="#">Section 4.2</a></li>
                                    <li><a href="#">Section 4.3</a></li>
                                    <li>
                                        <a href="#">Section 4.4</a>
                                        <ul>
                                            <li><a href="#">Section 4.4.1</a></li>
                                            <li><a href="#">Section 4.4.2</a></li>
                                            <li><a href="#">Section 4.4.4</a></li>
                                            <li><a href="#">Section 4.4.5</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="#">Section5</a></li>
                            <li><a href="#">Section6</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- header -->
<header>
    <div class="container">
        <div class="row">
            <div class="span3">
                <div class="main-logo"><a href="dashboard.html"><img src="img/beoro_logo.png" alt="Beoro Admin"></a></div>
            </div>
            <div class="span5">
                <nav class="nav-icons">
                    <ul>
                        <li><a href="javascript:void(0)" class="ptip_s" title="Dashboard"><i class="icsw16-home"></i></a></li>
                        <li class="dropdown">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><i class="icsw16-create-write"></i> <span class="caret"></span></a>
                            <ul role="menu" class="dropdown-menu">
                                <li role="presentation"><a href="#" role="menuitem">Action</a></li>
                                <li role="presentation"><a href="#" role="menuitem">Another action</a></li>
                                <li class="divider" role="presentation"></li>
                                <li role="presentation"><a href="#" role="menuitem">Separated link</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0)" class="ptip_s" title="Mailbox"><i class="icsw16-mail"></i><span class="badge badge-info">6</span></a></li>
                        <li><a href="javascript:void(0)" class="ptip_s" title="Comments"><i class="icsw16-speech-bubbles"></i><span class="badge badge-important">14</span></a></li>
                        <li class="active"><span class="ptip_s" title="Statistics (active)"><i class="icsw16-graph"></i></span></li>
                        <li><a href="javascript:void(0)" class="ptip_s" title="Settings"><i class="icsw16-cog"></i></a></li>
                    </ul>
                </nav>
            </div>
            <div class="span4">
                <div class="user-box">
                    <div class="user-box-inner">
                        <img src="https://secure.gravatar.com/avatar/<?php echo md5(strtolower(trim($current_user->email))); ?>?d=mm" alt="" class="user-avatar img-avatar">
                        <div class="user-info">
                            Welcome, <strong>Jonathan</strong>
                            <ul class="unstyled">
                                <li><a href="user_profile.html">Settings</a></li>
                                <li>&middot;</li>
                                <li><a href="login.html">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- breadcrumbs -->
<div class="container">
    <ul id="breadcrumbs">
        <li><a href="javascript:void(0)"><i class="icon-home"></i></a></li>
        <li><a href="javascript:void(0)">Content</a></li>
        <li><a href="javascript:void(0)">Article: Lorem ipsum dolor...</a></li>
        <li><a href="javascript:void(0)">Comments</a></li>
        <li><span>Lorem ipsum dolor sit amet...</span></li>
    </ul>
</div>



<?php echo $content; ?>


<?php if (Auth::has_access('user.view')): ?>
<div class="container">
    <div class="footer_space"></div>
</div>

<!-- footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="span12">
                <div>
                     <p style="color: silver; font-weight: bold; text-align: center;">Intranet: <?php echo exec('git describe --tags --long'); ?> (<?php echo exec('git rev-parse --abbrev-ref HEAD'); ?>) - Fuel: <?php echo e(Fuel::VERSION); ?> - Render Time: {exec_time}s - Memory Use: {mem_usage}mb</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php endif; ?>

<!-- Common JS -->
<!-- jQuery framework -->
<?php echo Asset::js('jquery.min.js'); ?>
<?php echo Asset::js('jquery-migrate.js'); ?>
<!-- bootstrap Framework plugins -->
<?php echo Asset::js('bootstrap.min.js'); ?>
<!-- top menu -->
<?php echo Asset::js('jquery.fademenu.js'); ?>
<!-- top mobile menu -->
<?php echo Asset::js('selectnav.min.js'); ?>
<!-- actual width/height of hidden DOM elements -->
<?php echo Asset::js('jquery.actual.min.js'); ?>
<!-- jquery easing animations -->
<?php echo Asset::js('jquery.easing.1.3.min.js'); ?>
<!-- power tooltips -->
<?php echo Asset::js('lib/powertip/jquery.powertip-1.1.0.min.js'); ?>
<!-- date library -->
<?php echo Asset::js('moment.min.js'); ?>
<!-- common functions -->
<?php echo Asset::js('beoro_common.js'); ?>

<!-- datatables -->
<?php echo Asset::js('lib/datatables/js/jquery.dataTables.min.js'); ?>
<!-- datatables column reorder -->
<?php echo Asset::js('lib/datatables/extras/ColReorder/media/js/ColReorder.min.js'); ?>
<!-- datatables column toggle visibility -->
<?php echo Asset::js('lib/datatables/extras/ColVis/media/js/ColVis.min.js'); ?>
<!-- datatable table tools -->
<?php echo Asset::js('lib/datatables/extras/TableTools/media/js/TableTools.min.js'); ?>
<?php echo Asset::js('lib/datatables/extras/TableTools/media/js/ZeroClipboard.js'); ?>
<!-- datatables bootstrap integration -->
<?php echo Asset::js('lib/datatables/js/jquery.dataTables.bootstrap.min.js'); ?>

<?php echo Asset::js('pages/beoro_datatables.js'); ?>


</body>
</html>