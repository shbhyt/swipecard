<?php
include("mysql_config.php");
?>
<HTML>
<head>
        <meta charset="utf-8">
        <title>Dashboard</title>
        <!-- Mobile specific metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- Force IE9 to render in normal mode -->
        <!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->
        <meta name="author" content="SuggeElson" />
        <meta name="description" content=""
        />
        <meta name="keywords" content=""
        />
        <meta name="application-name" content="sprFlat admin template" />
        <!-- Import google fonts - Heading first/ text second -->
        <link rel='stylesheet' type='text/css' 
        <!--[if lt IE 9]>

<![endif]-->
        <!-- Css files -->
        <!-- Icons -->
        <link href="assets/css/icons.css" rel="stylesheet" />
        <!-- jQueryUI -->
        <link href="assets/css/sprflat-theme/jquery.ui.all.css" rel="stylesheet" />
        <!-- Bootstrap stylesheets (included template modifications) -->
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <!-- Plugins stylesheets (all plugin custom css) -->
        <link href="assets/css/plugins.css" rel="stylesheet" />
        <!-- Main stylesheets (template main css file) -->
        <link href="assets/css/main.css" rel="stylesheet" />
        <!-- Custom stylesheets ( Put your own changes here ) -->
        <link href="assets/css/custom.css" rel="stylesheet" />
        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/img/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/img/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/img/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/img/ico/apple-touch-icon-57-precomposed.png">
        <link rel="icon" href="assets/img/ico/favicon.ico" type="image/png">
        <!-- Windows8 touch icon ( http://www.buildmypinnedsite.com/ )-->
        <meta name="msapplication-TileColor" content="#3399cc" />
    </head>
<BODY bgcolor="#FFFFFF" BACKGROUND="lbg.jpg">
	<div id="sidebar">
            <!-- Start .sidebar-inner -->
            <div class="sidebar-inner">
                <!-- Start #sideNav -->
                <ul id="sideNav" class="nav nav-pills nav-stacked">
                    <li class="top-search">
                        <form>
                            <input type="text" name="search" placeholder="Search ...">
                            <button type="submit"><i class="ec-search s20"></i>
                            </button>
                        </form>
                    </li>
                    <li><a href="index.html">Dashboard <i class="im-screen"></i></a>
                    </li>
                    <li><a href="charts.html">Charts <i class="st-chart"></i></a>
                    </li>
                    <li>
                        <a href="#"> Forms <i class="im-paragraph-justify"></i></a>
                        <ul class="nav sub">
                            <li><a href="forms.html"><i class="ec-pencil2"></i> Form Stuff</a>
                            </li>
                            <li><a href="form-validation.html"><i class="im-checkbox-checked"></i> Form Validation</a>
                            </li>
                            <li><a href="form-wizard.html"><i class="im-wand"></i> Form Wizard</a>
                            </li>
                            <li><a href="wysiwyg.html"><i class="fa-pencil"></i> WYSIWYG editor</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#"> Tables <i class="im-table2"></i></a>
                        <ul class="nav sub">
                            <li><a href="tables.html"><i class="en-arrow-right7"></i> Static tables</a>
                            </li>
                            <li><a href="data-tables.html"><i class="en-arrow-right7"></i> Data tables</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- End #sideNav -->
                <!-- Start .sidebar-panel -->
                
                <!-- End .sidebar-panel -->
            </div>
            <!-- End .sidebar-inner -->
        </div>
		
		<script src="assets/plugins/core/pace/pace.min.js"></script>
        <!-- Important javascript libs(put in all pages) -->
        <script src="assets/js/jquery-1.8.3.min.js"></script>
        <script>
        window.jQuery || document.write('<script src="assets/js/libs/jquery-2.1.1.min.js">\x3C/script>')
        </script>
        <script src="assets/js/jquery-ui.js"></script>
        <script>
        window.jQuery || document.write('<script src="assets/js/libs/jquery-ui-1.10.4.min.js">\x3C/script>')
        </script>
        <!--[if lt IE 9]>
  <script type="text/javascript" src="assets/js/libs/excanvas.min.js"></script>
  <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <script type="text/javascript" src="assets/js/libs/respond.min.js"></script>
<![endif]-->
        <!-- Bootstrap plugins -->
        <script src="assets/js/bootstrap/bootstrap.js"></script>
        <!-- Core plugins ( not remove ever) -->
        <!-- Handle responsive view functions -->
        <script src="assets/js/jRespond.min.js"></script>
        <!-- Custom scroll for sidebars,tables and etc. -->
        <script src="assets/plugins/core/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="assets/plugins/core/slimscroll/jquery.slimscroll.horizontal.min.js"></script>
        <!-- Resize text area in most pages -->
        <script src="assets/plugins/forms/autosize/jquery.autosize.js"></script>
        <!-- Proivde quick search for many widgets -->
        <script src="assets/plugins/core/quicksearch/jquery.quicksearch.js"></script>
        <!-- Bootbox confirm dialog for reset postion on panels -->
        <script src="assets/plugins/ui/bootbox/bootbox.js"></script>
        <!-- Other plugins ( load only nessesary plugins for every page) -->
        <script src="assets/plugins/charts/flot/jquery.flot.js"></script>
        <script src="assets/plugins/charts/flot/jquery.flot.pie.js"></script>
        <script src="assets/plugins/charts/flot/jquery.flot.resize.js"></script>
        <script src="assets/plugins/charts/flot/jquery.flot.time.js"></script>
        <script src="assets/plugins/charts/flot/jquery.flot.growraf.js"></script>
        <script src="assets/plugins/charts/flot/jquery.flot.categories.js"></script>
        <script src="assets/plugins/charts/flot/jquery.flot.stack.js"></script>
        <script src="assets/plugins/charts/flot/jquery.flot.tooltip.min.js"></script>
        <script src="assets/plugins/charts/flot/date.js"></script>
        <script src="assets/plugins/charts/sparklines/jquery.sparkline.js"></script>
        <script src="assets/plugins/charts/pie-chart/jquery.easy-pie-chart.js"></script>
        <script src="assets/plugins/forms/icheck/jquery.icheck.js"></script>
        <script src="assets/plugins/forms/tags/jquery.tagsinput.min.js"></script>
        <script src="assets/plugins/forms/tinymce/tinymce.min.js"></script>
        <script src="assets/plugins/misc/highlight/highlight.pack.js"></script>
        <script src="assets/plugins/misc/countTo/jquery.countTo.js"></script>
        <script src="assets/plugins/ui/weather/skyicons.js"></script>
        <script src="assets/plugins/ui/notify/jquery.gritter.js"></script>
        <script src="assets/plugins/ui/calendar/fullcalendar.js"></script>
        <script src="assets/js/jquery.sprFlat.js"></script>
        <script src="assets/js/app.js"></script>
        <script src="assets/js/pages/dashboard.js"></script>
						
</BODY>  
</HTML>