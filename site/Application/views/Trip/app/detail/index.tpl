
{*<link class="main-stylesheet" href="{$baseUrl}Public/pages/css/themes/simple.css" rel="stylesheet" type="text/css" />*}

{literal}
    <style>
        .container-fluid{
            padding-right: 0px !important;
            padding-left: 0px!important;
        }
        .container .jumbotron, .container-fluid .jumbotron{
            border-radius: 0px !important;
            height: 200px !important;
        }
        .padding-25 {
            padding: 0px !important;
        }
        .page-container .page-content-wrapper .content{
            padding-top: 0px !important;
        }
    </style>
    <script>
        $(document).ready(function () {
            if (location.hash) {
                $('a[href=\'' + location.hash + '\']').tab('show');
            }
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('a[href="' + activeTab + '"]').tab('show');
            }

            $('body').on('click', 'a[data-toggle=\'tab\']', function (e) {
                e.preventDefault()
                var tab_name = this.getAttribute('href')
                if (history.pushState) {
                    history.pushState(null, null, tab_name)
                } else {
                    location.hash = tab_name
                }
                localStorage.setItem('activeTab', tab_name)

                $(this).tab('show');
                return false;
            });
            $(window).on('popstate', function () {
                var anchor = location.hash ||
                        $('a[data-toggle=\'tab\']').first().attr('href');
                $('a[href=\'' + anchor + '\']').tab('show');
            });
        })
    </script>
{/literal}
<div class="social-wrapper">
    <div class="social " data-pages="social">
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax" data-social="cover">
            <div class="cover-photo">
                <img alt="Cover photo" src="{$trip->getFirstPhoto()}" />
            </div>
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="inner">
                    <div class="pull-bottom bottom-left m-b-40 m-l-30">
                        <h5 class="text-white no-margin">welcome to your trip</h5>
                        {*                        <h1 class="text-white no-margin"><span class="semi-bold">social</span> cover</h1>*}
                        <h1 class="text-white no-margin">{$trip->gettripname()}</h1>
                    </div>

                </div>

            </div>
        </div>
        <!-- END JUMBOTRON -->
        <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
            {$tripTabs}

            <!-- END FEED -->
        </div>
        <!-- END CONTAINER FLUID -->
    </div>
    <!-- /container -->
</div>

