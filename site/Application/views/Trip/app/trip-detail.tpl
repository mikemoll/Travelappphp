
{*<link class="main-stylesheet" href="{$baseUrl}Public/pages/css/themes/simple.css" rel="stylesheet" type="text/css" />*}

<div class="social-wrapper">
    <div class="social " data-pages="social">
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax" data-social="cover">
            <div class="cover-photo">
                <img alt="Cover photo" src="{$trip->getFirstPhoto()}" />
            </div>
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="inner">
                    <div class="pull-bottom bottom-left m-b-40">
                        <h5 class="text-white no-margin">welcome to your trip</h5>
                        {*                        <h1 class="text-white no-margin"><span class="semi-bold">social</span> cover</h1>*}
                        <h1 class="text-white no-margin">{$trip->gettripname()}</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- END JUMBOTRON -->
        <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
            <div class="feed">
                <!-- START DAY -->

                {section name=i loop=$TripplaceLst}

                    {literal}
                        <style>
                            .TripplaceLst-{/literal}{$TripplaceLst[i]->getID()}{literal}:after{
                                background-image: url({/literal}{$TripplaceLst[i]->getPhotoPath()}{literal}) !important;
                            }
                        </style>
                    {/literal}
                    <div class="col-md-4 col-xlg-4 box-item" >
                        <div class="ar-1-1">
                            <!-- START WIDGET widget_imageWidgetBasic-->
                            <div class="widget-2 panel no-border bg-primary widget widget-loader-circle-lg no-margin TripplaceLst-{$TripplaceLst[i]->getID()}">
                                <div class="panel-heading">
                                    <div class="panel-controls">
                                        <ul>
                                            <li>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body gallery-item2"   >
                                    <div class="pull-bottom bottom-left bottom-right padding-15">
                                        <span class="label font-montserrat fs-11">Place</span>
                                        <br>
                                        <h3 class="text-white">{$TripplaceLst[i]->getName()}</h3>
                                        <p class="text-white hint-text hidden-md">{$TripplaceLst[i]->getstartdate()} to {$TripplaceLst[i]->getenddate()} </p>
                                    </div>
                                </div>
                            </div>
                            <!-- END WIDGET -->
                        </div>

                    </div>
                {/section}
                {section name=i loop=$TripActivityLst}

                    {literal}
                        <style>
                            .TripActivityLst-{/literal}{$TripActivityLst[i]->getID()}{literal}:after{
                                background-image: url({/literal}{$TripActivityLst[i]->getPhotoPath()}{literal}) !important;
                            }
                        </style>
                    {/literal}
                    <div class="col-md-3 col-xlg-3 box-item" >
                        <div class="ar-1-1">
                            <!-- START WIDGET widget_imageWidgetBasic-->
                            <div class="widget-2 panel no-border bg-primary widget widget-loader-circle-lg no-margin TripActivityLst-{$TripActivityLst[i]->getID()}">
                                <div class="panel-heading">
                                    <div class="panel-controls">
                                        <ul>
                                            <li>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body gallery-item2"   >
                                    <div class="pull-bottom bottom-left bottom-right padding-15">
                                        <span class="label font-montserrat fs-11">Activity</span>
                                        <br>
                                        <h3 class="text-white">{$TripActivityLst[i]->getActivityName()}</h3> 
                                    </div>
                                </div>
                            </div>
                            <!-- END WIDGET -->
                        </div>

                    </div>
                {/section}

                <!-- END DAY -->
            </div>
            <!-- END FEED -->
        </div>
        <!-- END CONTAINER FLUID -->
    </div>
    <!-- /container -->
</div>