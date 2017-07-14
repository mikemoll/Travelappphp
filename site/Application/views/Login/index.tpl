<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>{$TituloPagina}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
        <link rel="apple-touch-icon" href="{$baseUrl}Public/pages/ico/60.png">
        <link rel="apple-touch-icon" sizes="76x76" href="{$baseUrl}Public/pages/ico/76.png">
        <link rel="apple-touch-icon" sizes="120x120" href="{$baseUrl}Public/pages/ico/120.png">
        <link rel="apple-touch-icon" sizes="152x152" href="{$baseUrl}Public/pages/ico/152.png">
        <link rel="icon" type="image/x-icon" href="favicon.ico" />
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
        {literal}
            <script type="text/javascript">
                window.onload = function ()
                {
                    // fix for windows 8
                    if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
                        document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="{$baseUrl}Public/pages/css/windows.chrome.fix.css" />'
                }
            </script>
        {/literal}
        <!-- This is the onli JS that has to be on the begining, cuz there are some components that need this before everithing else! (Leonardo )-->
        <script src="{$baseUrl}Public/assets/plugins/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
    </head>
    <body class="fixed-header ">
        <div>
            <link href="{$baseUrl}Public/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
            <link href="{$baseUrl}Public/assets/plugins/bootstrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
            <link href="{$baseUrl}Public/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
            <link href="{$baseUrl}Public/assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" media="screen" />
            <link href="{$baseUrl}Public/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" media="screen" />
            <link href="{$baseUrl}Public/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
            <link href="{$baseUrl}Public/pages/css/pages-icons.css" rel="stylesheet" type="text/css">
            <link class="main-stylesheet" href="{$baseUrl}Public/pages/css/pages.css" rel="stylesheet" type="text/css" />
{*             <link href="{$baseUrl}Public/assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" media="screen">*}
            <!--[if lte IE 9]>
                <link href="{$baseUrl}Public/pages/css/ie9.css" rel="stylesheet" type="text/css" />
            <![endif]-->

            {$scriptsCss}
        </div>
        <div class="login-wrapper ">
            <!-- START Login Background Pic Wrapper-->
            <div class="bg-pic">
                <!-- START Background Pic-->
                <img src="{$baseUrl}Public/assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg" data-src="{$baseUrl}Public/assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg" data-src-retina="{$baseUrl}Public/assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg" alt="" class="lazy">
                <!-- END Background Pic-->
                <!-- START Background Caption-->
                <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
                    <h2 class="semi-bold text-white">
                        Tumbleweed</h2>
                    <h2 class="semi-bold text-white">
                        go everywhere</h2>
                    <p class="small">
                        All work copyright | © 2017 Travel Track.
                    </p>
                </div>
                <!-- END Background Caption-->
            </div>
            <!-- END Login Background Pic Wrapper-->
            <!-- START Login Right Container-->
            <div class="login-container bg-white">
                <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
                    {* <img src="{$baseUrl}Public/assets/img/logo.png" alt="logo" data-src="{$baseUrl}Public/assets/img/logo.png" data-src-retina="assets/img/logo_2x.png" width="78" height="22"> *}
                    {$body}
                </div>
            </div>
            <!-- END Login Right Container-->
        </div>

        <!-- BEGIN VENDOR JS -->
        <script src="{$baseUrl}Public/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
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
        <script src="{$baseUrl}Public/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="{$baseUrl}Public/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>

        <!-- END VENDOR JS -->
        <script src="{$baseUrl}Public/pages/js/pages.min.js"></script>
        <!-- BEGIN FRAMEWORK JS-->
        {$scriptsJs}
        <!-- END FRAMEWORK JS-->

        {literal}
            <script>
                $(function ()
                {
                    $('#form-login').validate()
                })
            </script>

        {/literal}
    </body>
</html>


