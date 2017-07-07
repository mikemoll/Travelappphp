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
            <script type="text/javascript">
                window.onload = function ()
                {
                    // fix for windows 8
                    if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
                        document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="{$baseUrl}Public/pages/css/windows.chrome.fix.css" />'
                }
            </script>
        {/literal}
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
            <!--[if lte IE 9]>
                <link href="{$baseUrl}Public/pages/css/ie9.css" rel="stylesheet" type="text/css" />
            <![endif]-->

            {$scriptsCss}
        </div>
        <div class="login-wrapper ">
            <!-- START Login Background Pic Wrapper-->
            <div class="bg-pic">
                <!-- START Background Pic-->
                <img src="{$baseUrl}Public/assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg" data-src="{$baseUrl}Public/assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg" data-src-retina="assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg" alt="" class="lazy">
                <!-- END Background Pic-->
                <!-- START Background Caption-->
                <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
                    <h2 class="semi-bold text-white">
                        Pages make it easy to enjoy what matters the most in the life</h2>
                    <p class="small">
                        images Displayed are solely for representation purposes only, All work copyright of respective owner, otherwise © 2013-2014 REVOX.
                    </p>
                </div>
                <!-- END Background Caption-->
            </div>
            <!-- END Login Background Pic Wrapper-->
            <!-- START Login Right Container-->
            <div class="login-container bg-white">
                <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
                    <img src="{$baseUrl}Public/assets/img/logo.png" alt="logo" data-src="{$baseUrl}Public/assets/img/logo.png" data-src-retina="assets/img/logo_2x.png" width="78" height="22">
                    <p class="p-t-35">Sign into your pages account</p>
                    <p id=""msg></p>
                    {$body}

                    <div class="pull-bottom sm-pull-bottom">
                        <div class="m-b-30 p-r-80 sm-m-t-20 sm-p-r-15 sm-p-b-20 clearfix">
                            <div class="col-sm-3 col-md-2 no-padding">
                                <img alt="" class="m-t-5" data-src="{$baseUrl}Public/assets/img/demo/pages_icon.png" data-src-retina="assets/img/demo/pages_icon_2x.png" height="60" src="{$baseUrl}Public/assets/img/demo/pages_icon.png" width="60">
                            </div>
                            <div class="col-sm-9 no-padding m-t-10">
                                <p>
                                    <small>
                                        Create a pages account. If you have a facebook account, log into it for this
                                        process. Sign in with <a href="#" class="text-info">Facebook</a> or <a href="#"
                                                                                                               class="text-info">Google</a>
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Login Right Container-->
        </div>
        <!-- START OVERLAY -->
        <div class="overlay hide" data-pages="search">
            <!-- BEGIN Overlay Content !-->
            <div class="overlay-content has-results m-t-20">
                <!-- BEGIN Overlay Header !-->
                <div class="container-fluid">
                    <!-- BEGIN Overlay Logo !-->
                    <img class="overlay-brand" src="{$baseUrl}Public/assets/img/logo.png" alt="logo" data-src="{$baseUrl}Public/assets/img/logo.png" data-src-retina="assets/img/logo_2x.png" width="78" height="22">
                    <!-- END Overlay Logo !-->
                    <!-- BEGIN Overlay Close !-->
                    <a href="#" class="close-icon-light overlay-close text-black fs-16">
                        <i class="pg-close"></i>
                    </a>
                    <!-- END Overlay Close !-->
                </div>
                <!-- END Overlay Header !-->
                <div class="container-fluid">
                    <!-- BEGIN Overlay Controls !-->
                    <input id="overlay-search" class="no-border overlay-search bg-transparent" placeholder="Search..." autocomplete="off" spellcheck="false">
                    <br>
                    <div class="inline-block">
                        <div class="checkbox right">
                            <input id="checkboxn" type="checkbox" value="1" checked="checked">
                            <label for="checkboxn"><i class="fa fa-search"></i> Search within page</label>
                        </div>
                    </div>
                    <div class="inline-block m-l-10">
                        <p class="fs-13">Press enter to search</p>
                    </div>
                    <!-- END Overlay Controls !-->
                </div>
                <!-- BEGIN Overlay Search Results, This part is for demo purpose, you can add anything you like !-->
                <div class="container-fluid">
                    <span>
                        <strong>suggestions :</strong>
                    </span>
                    <span id="overlay-suggestions"></span>
                    <br>
                    <div class="search-results m-t-40">
                        <p class="bold">Pages Search Results</p>
                        <div class="row">
                            <div class="col-md-6">
                                <!-- BEGIN Search Result Item !-->
                                <div class="">
                                    <!-- BEGIN Search Result Item Thumbnail !-->
                                    <div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                                        <div>
                                            <img width="50" height="50" src="{$baseUrl}Public/assets/img/profiles/avatar.jpg" data-src="{$baseUrl}Public/assets/img/profiles/avatar.jpg" data-src-retina="assets/img/profiles/avatar2x.jpg" alt="">
                                        </div>
                                    </div>
                                    <!-- END Search Result Item Thumbnail !-->
                                    <div class="p-l-10 inline p-t-5">
                                        <h5 class="m-b-5"><span class="semi-bold result-name">ice cream</span> on pages</h5>
                                        <p class="hint-text">via john smith</p>
                                    </div>
                                </div>
                                <!-- END Search Result Item !-->
                                <!-- BEGIN Search Result Item !-->
                                <div class="">
                                    <!-- BEGIN Search Result Item Thumbnail !-->
                                    <div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                                        <div>T</div>
                                    </div>
                                    <!-- END Search Result Item Thumbnail !-->
                                    <div class="p-l-10 inline p-t-5">
                                        <h5 class="m-b-5"><span class="semi-bold result-name">ice cream</span> related topics</h5>
                                        <p class="hint-text">via pages</p>
                                    </div>
                                </div>
                                <!-- END Search Result Item !-->
                                <!-- BEGIN Search Result Item !-->
                                <div class="">
                                    <!-- BEGIN Search Result Item Thumbnail !-->
                                    <div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                                        <div><i class="fa fa-headphones large-text "></i>
                                        </div>
                                    </div>
                                    <!-- END Search Result Item Thumbnail !-->
                                    <div class="p-l-10 inline p-t-5">
                                        <h5 class="m-b-5"><span class="semi-bold result-name">ice cream</span> music</h5>
                                        <p class="hint-text">via pagesmix</p>
                                    </div>
                                </div>
                                <!-- END Search Result Item !-->
                            </div>
                            <div class="col-md-6">
                                <!-- BEGIN Search Result Item !-->
                                <div class="">
                                    <!-- BEGIN Search Result Item Thumbnail !-->
                                    <div class="thumbnail-wrapper d48 circular bg-info text-white inline m-t-10">
                                        <div><i class="fa fa-facebook large-text "></i>
                                        </div>
                                    </div>
                                    <!-- END Search Result Item Thumbnail !-->
                                    <div class="p-l-10 inline p-t-5">
                                        <h5 class="m-b-5"><span class="semi-bold result-name">ice cream</span> on facebook</h5>
                                        <p class="hint-text">via facebook</p>
                                    </div>
                                </div>
                                <!-- END Search Result Item !-->
                                <!-- BEGIN Search Result Item !-->
                                <div class="">
                                    <!-- BEGIN Search Result Item Thumbnail !-->
                                    <div class="thumbnail-wrapper d48 circular bg-complete text-white inline m-t-10">
                                        <div><i class="fa fa-twitter large-text "></i>
                                        </div>
                                    </div>
                                    <!-- END Search Result Item Thumbnail !-->
                                    <div class="p-l-10 inline p-t-5">
                                        <h5 class="m-b-5">Tweats on<span class="semi-bold result-name"> ice cream</span></h5>
                                        <p class="hint-text">via twitter</p>
                                    </div>
                                </div>
                                <!-- END Search Result Item !-->
                                <!-- BEGIN Search Result Item !-->
                                <div class="">
                                    <!-- BEGIN Search Result Item Thumbnail !-->
                                    <div class="thumbnail-wrapper d48 circular text-white bg-danger inline m-t-10">
                                        <div><i class="fa fa-google-plus large-text "></i>
                                        </div>
                                    </div>
                                    <!-- END Search Result Item Thumbnail !-->
                                    <div class="p-l-10 inline p-t-5">
                                        <h5 class="m-b-5">Circles on<span class="semi-bold result-name"> ice cream</span></h5>
                                        <p class="hint-text">via google plus</p>
                                    </div>
                                </div>
                                <!-- END Search Result Item !-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Overlay Search Results !-->
            </div>
            <!-- END Overlay Content !-->
        </div>
        <!-- END OVERLAY -->
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
        <!-- END VENDOR JS -->
        <script src="pages/js/pages.min.js"></script>
        {$scriptsJs}

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


