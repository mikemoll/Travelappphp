<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>{$TituloPagina} - {$NomeSistema}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
        {*<link rel="apple-touch-icon" href="{$baseUrl}Public/pages/ico/60.png">
        <link rel="apple-touch-icon" sizes="76x76" href="{$baseUrl}Public/pages/ico/76.png">
        <link rel="apple-touch-icon" sizes="120x120" href="{$baseUrl}Public/pages/ico/120.png">
        <link rel="apple-touch-icon" sizes="152x152" href="{$baseUrl}Public/pages/ico/152.png">*}
        <link rel="icon" type="image/png" href="{$baseUrl}Public/Images/favicon/favicon.png" />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta content="" name="description" />
        <meta content="" name="author" />

        <script type="text/javascript">
            eval("base = '{$baseUrl}'");
            var cBaseUrl = '{$baseUrl}';
            var HTTP_HOST = '{$HTTP_HOST}';
        </script>
        {literal}
            <style>
                .max-char-text {
                    position: absolute;
                    right: 20px;
                    top: 2px;
                    font-size: smaller;
                    color: #ccc;
                }
            </style>
        {/literal}
        <!-- This is the onli JS that has to be on the begining, cuz there are some components that need this before everithing else! (Leonardo )-->
        <script src="{$baseUrl}Public/assets/plugins/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
    </head>
    {*    <body class="fixed-header dashboard menu-pin menu-behind">*}
    <body class="fixed-header dashboard menu-pin ">
        <div>
            <link href="{$baseUrl}Public/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
            <link href="{$baseUrl}Public/assets/plugins/bootstrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
            <link href="{$baseUrl}Public/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
            <link href="{$baseUrl}Public/assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" media="screen" />
            <link href="{$baseUrl}Public/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" media="screen" />
            <link href="{$baseUrl}Public/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
            <link href="{$baseUrl}Public/assets/plugins/nvd3/nv.d3.min.css" rel="stylesheet" type="text/css" media="screen" />
            <link href="{$baseUrl}Public/assets/plugins/mapplic/css/mapplic.css" rel="stylesheet" type="text/css" />
            <link href="{$baseUrl}Public/assets/plugins/rickshaw/rickshaw.min.css" rel="stylesheet" type="text/css" />
            <link href="{$baseUrl}Public/assets/plugins/jquery-metrojs/MetroJs.css" rel="stylesheet" type="text/css" media="screen" />
            <link href="{$baseUrl}Public/pages/css/pages-icons.css" rel="stylesheet" type="text/css">
            <link href="{$baseUrl}Public/assets/css/style.css" rel="stylesheet" type="text/css">
            <link class="main-stylesheet" href="{$baseUrl}Public/pages/css/pages.css" rel="stylesheet" type="text/css" />

            <!--[if lte IE 9]>
                <link href="{$baseUrl}Public/assets/plugins/codrops-dialogFx/dialog.ie.css" rel="stylesheet" type="text/css" media="screen" />
                <![endif]-->
            {$scriptsCss}
            {literal}
            <script>
                window.intercomSettings = {
                    app_id: "uypl4r9y",
                    name: "{/literal}{$usuarioLogado}{literal}",
                    email: "{/literal}{$userEmail}{literal}",
                    created_at: {/literal}{$userCreatedAtUnixTimestamp}{literal}
                };
            </script>
            <script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/APP_ID';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()
            </script>
            {/literal}
        </div>

        <!-- START PAGE-CONTAINER -->
        <div class="page-container ">
            <!-- START PAGE CONTENT WRAPPER -->
            <div class="page-content-wrapper ">
                {$body}

                <!-- START COPYRIGHT -->
                <!-- START CONTAINER FLUID -->
                <!-- START CONTAINER FLUID -->
                <div class="container-fluid container-fixed-lg footer" style="left: 0px;">
                    <div class="copyright sm-text-center">
                        <p class="small no-margin pull-left sm-pull-reset">
                            <span class="hint-text">Copyright &copy; 2017 </span>
                            <span class="font-montserrat">Tumbleweed</span>.
                            <span class="hint-text">All rights reserved. </span>
                            <span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> | <a href="#" class="m-l-10">Privacy Policy</a></span>
                        </p>
                        <p class="small no-margin pull-right sm-pull-reset">
                            <!-- <a href="#">Hand-crafted</a> <span class="hint-text">&amp; Made with Love ®</span> -->
                        </p>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!-- END COPYRIGHT -->
            </div>
            <!-- END PAGE CONTENT WRAPPER -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- BEGIN VENDOR JS -->
        <script src="{$baseUrl}Public/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/modernizr.custom.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/bootstrapv3/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/jquery/jquery-easy.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/jquery-bez/jquery.bez.min.js"></script>
        <script src="{$baseUrl}Public/assets/plugins/jquery-ios-list/jquery.ioslist.min.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/jquery-actual/jquery.actual.min.js"></script>
        <script src="{$baseUrl}Public/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js"></script>
        <script type="text/javascript" src="{$baseUrl}Public/assets/plugins/select2/js/select2.full.min.js"></script>
        <script type="text/javascript" src="{$baseUrl}Public/assets/plugins/classie/classie.js"></script>
        <script src="{$baseUrl}Public/assets/plugins/switchery/js/switchery.min.js" type="text/javascript"></script>
        <!-- end of default js -->
        <!-- From here down, is the dashbord js (I think so!) -->
        {*
        <script src="{$baseUrl}Public/assets/plugins/nvd3/lib/d3.v3.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/nvd3/nv.d3.min.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/nvd3/src/utils.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/nvd3/src/tooltip.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/nvd3/src/interactiveLayer.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/nvd3/src/models/axis.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/nvd3/src/models/line.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/nvd3/src/models/lineWithFocusChart.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/mapplic/js/hammer.js"></script>
        <script src="{$baseUrl}Public/assets/plugins/mapplic/js/jquery.mousewheel.js"></script>
        <script src="{$baseUrl}Public/assets/plugins/mapplic/js/mapplic.js"></script>
        <script src="{$baseUrl}Public/assets/plugins/rickshaw/rickshaw.min.js"></script>
        <script src="{$baseUrl}Public/assets/plugins/jquery-metrojs/MetroJs.min.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/jquery-sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/skycons/skycons.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>*}
        <!-- END VENDOR JS -->

        <!-- BEGIN FRAMEWORK JS-->
        {$scriptsJs}
        <!-- END FRAMEWORK JS-->

        <!-- BEGIN CORE TEMPLATE JS -->
        <script src="{$baseUrl}Public/pages/js/pages.min.js"></script>
        <!-- END CORE TEMPLATE JS -->
        <!-- BEGIN PAGE LEVEL JS -->
        {*        <script src="{$baseUrl}Public/assets/js/dashboard.js" type="text/javascript"></script>*}
        {*        <script src="{$baseUrl}Public/assets/js/scripts.js" type="text/javascript"></script>*}
        <!-- END PAGE LEVEL JS -->
    </body>
</html>