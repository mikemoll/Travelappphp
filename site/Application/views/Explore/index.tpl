

<link href="{$baseUrl}Public/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
<link href="{$baseUrl}Public/assets/plugins/bootstrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="{$baseUrl}Public/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
<link href="{$baseUrl}Public/assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" media="screen" />
<link href="{$baseUrl}Public/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" media="screen" />
<link href="{$baseUrl}Public/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
<link href="{$baseUrl}Public/assets/plugins/jquery-metrojs/MetroJs.css" rel="stylesheet" type="text/css" media="screen" />
<link href="{$baseUrl}Public/assets/plugins/codrops-dialogFx/dialog.css" rel="stylesheet" type="text/css" media="screen" />
<link href="{$baseUrl}Public/assets/plugins/codrops-dialogFx/dialog-sandra.css" rel="stylesheet" type="text/css" media="screen" />
<link href="{$baseUrl}Public/assets/plugins/owl-carousel/assets/owl.carousel.css" rel="stylesheet" type="text/css" media="screen" />
<link href="{$baseUrl}Public/assets/plugins/jquery-nouislider/jquery.nouislider.css" rel="stylesheet" type="text/css" media="screen" />
<link href="{$baseUrl}Public/pages/css/pages-icons.css" rel="stylesheet" type="text/css">
<link class="main-stylesheet" href="{$baseUrl}Public/pages/css/pages.css" rel="stylesheet" type="text/css" />

{if $EventtypeLst|@count > 0}
    {literal}
        <script>
            $(document).ready(function () {
                $('#typeFilter').change(function () {
                    var val = $(this).val();
                    switch (val) {
                        case 'E':
                            $('#E').show();
                            $('#A').hide();
                            break;
                        case 'A':
                            $('#A').show();
                            $('#E').hide();
                            break;
                        default:
                            $('#E').hide();
                            $('#A').hide();
                            break;
                    }

                })
            })
        </script>
    {/literal}
    <div class="advanced-filters">
        {*Main filters
        Place - Activity - Event -  date range - Rating - Budget - Activity event  - event type - trip type*}
        <div class="row">
            <div class="col-md-1 collapse in " id="Country">
                <a class="hint-text btn" style="width: 100%" href="#moreFiltersCountry" data-toggle="collapse">Country<span class="caret"></span></a>
                <ul class="list-group text-center collapse dropdown-menu  " style="width: 100%" id="moreFiltersCountry"  >
                    {foreach key=key from=$CountryLst item=item }
                        <a  class="list-group-item {if $CountrySelected == $key}active{/if}" class="text-center" href="{$HTTP_REFERER}{$BASE}explore/index/{if $CountrySelected != $key}country/{$key}_{$item}/{/if}{$links.country}">{$item}</a>
                    {/foreach}
                </ul>
            </div>
            <div class="col-md-1 collapse in " id="City">
                <a class="hint-text btn" style="width: 100%" href="#moreFiltersCity" data-toggle="collapse">City<span class="caret"></span></a>
                <ul class="list-group text-center collapse dropdown-menu  " style="width: 100%" id="moreFiltersCity"  >
                    {foreach key=key from=$CityLst item=item }
                        <a  class="list-group-item {if $CitySelected == $key}active{/if}" class="text-center" href="{$HTTP_REFERER}{$BASE}explore/index/{if $CitySelected != $key}city/{$key}_{$item}/{/if}{$links.city}">{$item}</a>
                    {/foreach}
                </ul>
            </div>
            {*<div class="col-md-1" >
            {$typeFilter}
            </div>*}
            <div class="col-md-2     " id="E">
                <a class="hint-text btn" style="width: 100%" href="#moreFiltersEvent" data-toggle="collapse">Event Type<span class="caret"></span></a>
                <ul class="list-group text-center collapse dropdown-menu  " style="width: 100%" id="moreFiltersEvent"  >
                    {foreach key=key from=$EventtypeLst item=item }
                        <a  class="list-group-item {if $EventtypeSelected == $key}active{/if}" class="text-center" href="{$HTTP_REFERER}{$BASE}explore/index/{if $EventtypeSelected != $key}eventtype/{$key}_{$item}/{/if}{$links.eventtype}">{$item}</a>
                    {/foreach}
                </ul>
            </div>
            <div class="col-md-2     " id="A" >
                <a class="hint-text btn" style="width: 100%" href="#moreFiltersActivity" data-toggle="collapse">Activity Type<span class="caret"></span></a>
                <ul class="list-group text-center collapse dropdown-menu  " style="width: 100%" id="moreFiltersActivity"  >
                    {foreach key=key from=$ActivitytypeLst item=item }
                        <a class="list-group-item {if $ActivitytypeSelected == $key}active{/if}" href="{$HTTP_REFERER}{$BASE}explore/index/{if $ActivitytypeSelected != $key}activitytype/{$key}_{$item}/{/if}{$links.activitytype}" >{$item}</a>
                    {/foreach}
                </ul>
            </div>
            {*<div class="col-md-2" >
            <div class="form-group form-group-default">
            <label class="fade">Rating</label>
            <a href="{$HTTP_REFERER}{$BASE}explore/index/rating/1/{$links.base}" class=""><i class="fa {if 1 <= $ratingSelected}fa-star{else}fa-star-o{/if}"></i></a>
            <a href="{$HTTP_REFERER}{$BASE}explore/index/rating/2/{$links.base}" class=""><i class="fa {if 2 <= $ratingSelected}fa-star{else}fa-star-o{/if}"></i></a>
            <a href="{$HTTP_REFERER}{$BASE}explore/index/rating/3/{$links.base}" class=""><i class="fa {if 3 <= $ratingSelected}fa-star{else}fa-star-o{/if}"></i></a>
            <a href="{$HTTP_REFERER}{$BASE}explore/index/rating/4/{$links.base}" class=""><i class="fa {if 4 <= $ratingSelected}fa-star{else}fa-star-o{/if}"></i></a>
            <a href="{$HTTP_REFERER}{$BASE}explore/index/rating/5/{$links.base}" class=""><i class="fa {if 5 <= $ratingSelected}fa-star{else}fa-star-o{/if}"></i></a>
            </div>
            </div>*}
            {*<div class="col-md-6" >
            <div class="input-daterange input-group" id="datepicker-range">
            {$startdate}
            <span class="input-group-addon">to</span>
            {$enddate}
            </div>
            <div class="pull-right" >{$btnApplyDate}</div>

            </div>*}
        </div>

        {if $appliedFilters|@count > 0}
            <section class="applied-filters clearfix">

                <ul class="list-unstyled ">
                    <li class="hint-text">Applied Filters: <a href="{$HTTP_REFERER}{$BASE}explore/index/" class=""><i class="fa fa-close"></i> remove all filters</a></li>
                    <li>
                        {foreach key=key from=$appliedFilters item=item }
                            <a href="{$HTTP_REFERER}{$BASE}explore/index/{$links[$key]}" class="btn btn-sm  ">{$names[$key]} <i class="fa fa-close"></i></a>
                            {/foreach}
                    </li>
                </ul>
            </section>
        {/if}
    </div>
{/if}
<div class="row text-center">
    <div class="col-sm-12">
        <h1 ><span style="font-size: 130%">{$title1}</span></h1>
        <h3>{$title2}</h3>

        {$btnDiscover}
        {$btnCreateTrip}
    </div>
</div>
{*<script>
$('#daterangepicker').daterangepicker({
timePicker: true,
timePickerIncrement: 30,
format: 'MM/DD/YYYY h:mm A'
}, function (start, end, label) {
console.log(start.toISOString(), end.toISOString(), label);
});
</script>*}
{literal}
    <style>
        .gallery-item2{
            cursor:pointer; 
        }
        #itemDescription{
            height: 280px;
            overflow-y: auto;
            width: 314px;
        }
        .item-details .dialog__content .dialog__footer .recommended li img {
            width: 100%;
            height: 100%;
            display: block;
            overflow: hidden;
        }
        .item-buttons{
            float: right;
            position: absolute;
            bottom: 5px;
            width: 100%;
        }
    </style>
{/literal}


<div class="row" >
    <div class="col-md-4 col-xlg-4 " >

        {section name=i loop=$placeLst}

            {literal}
                <style>
                    .place-{/literal}{$placeLst[i]->getID()}{literal}:after{
                        background-image: url({/literal}{$placeLst[i]->getPhotoPath()}{literal}) !important;
                    }
                </style>
            {/literal}
            <div class="row">
                <div class="col-md-12 col-xlg-12 m-b-10 m-r-10" >
                    <div class="ar-1-1  b-rad-25">
                        <!-- START WIDGET widget_imageWidgetBasic-->
                        <div class="widget-2 panel no-border bg-primary widget widget-loader-circle-lg no-margin place-{$placeLst[i]->getID()}">
                            <div class="panel-heading">
                                <div class="panel-controls">
                                    <ul>
                                        <li>
                                            <a class="widget-3-fav no-decoration" style="{if $placeLst[i]->getFavorite()!=''}display: none;{/if}" href="#none" id="btnadddream"
                                               name="btnadddream"  event="click" url="explore"
                                               params="id_place={$placeLst[i]->getID()}&cardname={$placeLst[i]->getName()}">
                                                <i class="fa fa-heart-o fa-2x" style="color: red"></i>
                                            </a>
                                            <a class="widget-3-fav no-decoration" style="{if $placeLst[i]->getFavorite()==''}display: none;{/if}" href="#none" id="btnremovedream"
                                               name="btnremovedream"  event="click" url="explore"
                                               params="id_place={$placeLst[i]->getID()}">
                                                <i class="fa fa-heart fa-2x" style="color: red"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body gallery-item2" data-id="{$placeLst[i]->getID()}"  event="click" name="galeryItem" url='explore'   params="id_place={$placeLst[i]->getID()}&google_place_id={$placeLst[i]->getgoogle_place_id()}">
                                <div class="pull-bottom bottom-left bottom-right padding-15">
                                    <h3 class="text-white">{$placeLst[i]->getName()}</h3>
                                    {if $placeLst[i]->getFormatted_Address()!=''}
                                        <p class="text-white hint-text hidden-md">{$placeLst[i]->getFormatted_Address()}</p>
                                    {/if}
                                    <span class=" pull-right fs-11">{$placeLst[i]->getRatingHtml()}</span>
                                    <span class="label font-montserrat fs-11">Place</span>
                                </div>
                            </div>
                        </div>
                        <!-- END WIDGET -->
                    </div>
                </div>
            </div>
        {/section}
    </div>

    <div class="col-md-4 col-xlg-4 " >

        {section name=i loop=$activityLst}

            {literal}
                <style>
                    .activity-{/literal}{$activityLst[i]->getID()}{literal}:after{
                        background-image: url({/literal}{$activityLst[i]->getPhotoPath()}{literal}) !important;
                    }
                </style>
            {/literal}

            <div class="row">
                <div class="col-md-12 col-xlg-12 m-b-10  m-r-10" >
                    <div class="ar-1-1 b-rad-25">
                        <!-- START WIDGET widget_imageWidgetBasic-->
                        <div class="widget-2 panel no-border bg-primary widget widget-loader-circle-lg no-margin activity-{$activityLst[i]->getID()}">
                            <div class="panel-heading">
                                <div class="panel-controls">
                                    <ul>
                                        <li>
                                            <a class="widget-3-fav no-decoration" style="{if $activityLst[i]->getFavorite()!=''}display: none;{/if}" href="#none" id="btnadddream"
                                               name="btnadddream"  event="click" url="explore"
                                               params="id_activity={$activityLst[i]->getID()}&cardname={$activityLst[i]->getActivityName()}">
                                                <i class="fa fa-heart-o fa-2x" style="color: red"></i>
                                            </a>
                                            <a class="widget-3-fav no-decoration" style="{if $activityLst[i]->getFavorite()==''}display: none;{/if}" href="#none" id="btnremovedream"
                                               name="btnremovedream"  event="click" url="explore"
                                               params="id_activity={$activityLst[i]->getID()}">
                                                <i class="fa fa-heart fa-2x" style="color: red"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body gallery-item2" data-id="{$activityLst[i]->getID()}"  event="click" name="galeryItem" url='explore'   params="id_activity={$activityLst[i]->getID()}">
                                <div class="pull-bottom bottom-left bottom-right padding-15">
                                    <h3 class="text-white">{$activityLst[i]->getActivityName()}</h3>
                                    {if $activityLst[i]->getCity()!=''}
                                        <p class="text-white hint-text hidden-md">{$activityLst[i]->getCity()}, {$activityLst[i]->getCountry()}</p>
                                    {/if}
                                    <h3 class="text-white hidden-md  bold">{$activityLst[i]->getPriceOrFree()}</h3>
                                    <span class="label font-montserrat fs-11">Activity</span>
                                    <span class="label font-montserrat fs-11 text-white " style='background-color: #FF50FF;  '>{$activityLst[i]->getactivitytypename()}</span>

                                    <span class=" pull-right fs-11">{$activityLst[i]->getRatingHtml()}</span>
                                </div>
                            </div>
                        </div>
                        <!-- END WIDGET -->
                    </div>

                </div>
            </div>
        {/section}
    </div>

    <div class="col-md-4 col-xlg-4 " >

        <!-- START ROW -->
        {section name=i loop=$eventLst}

            {literal}
                <style>
                    .event-{/literal}{$eventLst[i]->getID()}{literal}:after{
                        background-image: url({/literal}{$eventLst[i]->getPhotoPath()}{literal}) !important;
                    }
                </style>
            {/literal}

            <div class="row">
                <div class="col-md-12 col-xlg-12 m-b-10 m-r-10">
                    <div class="ar-1-1 b-rad-25">
                        <!-- START WIDGET widget_imageWidgetBasic-->
                        <div class="widget-2 panel no-border bg-primary widget widget-loader-circle-lg no-margin event-{$eventLst[i]->getID()}">
                            <div class="panel-heading">
                                <div class="panel-controls">
                                    <ul>
                                        <li>
                                            <a class="widget-3-fav no-decoration" style="{if $eventLst[i]->getFavorite()!=''}display: none;{/if}" href="#none" id="btnadddream"
                                               name="btnadddream"  event="click" url="explore"
                                               params="id_event={$eventLst[i]->getID()}&cardname={$eventLst[i]->getEventName()}">
                                                <i class="fa fa-heart-o fa-2x" style="color: red"></i>
                                            </a>
                                            <a class="widget-3-fav no-decoration" style="{if $eventLst[i]->getFavorite()==''}display: none;{/if}" href="#none" id="btnremovedream"
                                               name="btnremovedream"  event="click" url="explore"
                                               params="id_event={$eventLst[i]->getID()}">
                                                <i class="fa fa-heart fa-2x" style="color: red"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body gallery-item2" data-id="{$eventLst[i]->getID()}"  event="click" name="galeryItem" url='explore'   params="id_event={$eventLst[i]->getID()}&cardname={$eventLst[i]->getEventName()}">
                                <div class="pull-bottom bottom-left bottom-right padding-15">
                                    <h3 class="text-white">{$eventLst[i]->getEventName()}</h3>
                                    {if $eventLst[i]->getCity()!=''}
                                        <p class="text-white hint-text hidden-md">{$eventLst[i]->getCity()}, {$eventLst[i]->getCountry()}</p>
                                    {/if}
                                    <span class="  font-montserrat ">{$eventLst[i]->getFormattedDate()}</span>
                                    <h3 class="text-white hidden-md  bold">{$eventLst[i]->getPriceOrFree()}</h3>
                                    <span class="label font-montserrat fs-11">Event</span>
                                    {*                                <span class="label font-montserrat fs-11 text-white " title="Click to filter by {$eventLst[i]->geteventtypename()}" href="{$HTTP_REFERER}{$BASE}explore/index/eventtype/{$eventLst[i]->getid_eventtype()}" style='background-color: #FF50FF;  '>{$eventLst[i]->geteventtypename()}</span>*}
                                    <span class="label font-montserrat fs-11 text-white " style='background-color: #FF50FF;  '>{$eventLst[i]->geteventtypename()}</span>

                                    <span class=" pull-right fs-11">{$eventLst[i]->getRatingHtml()}</span>
                                </div>
                            </div>
                        </div>
                        <!-- END WIDGET -->
                    </div>

                </div>
            </div>
        {/section}
    </div>
</div>


<!-- START DIALOG -->
<div id="itemDetails" class="dialog item-details">
    <div class="dialog__overlay"></div>
    <div class="dialog__content">
        <div class="container-fluid">
            <div class="row dialog__overview">
                <div class="col-sm-7 no-padding item-slideshow-wrapper full-height">
                    <div class="item-slideshow full-height itemGalery" id="itemDetailGalery">
                        <div class="slide" data-image="{$baseUrl}Public/Images/loading.gif">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 visible-xs bg-info-dark">
                    <div class="container-xs-height">
                        <div class="row row-xs-height">
                            <div class="col-xs-8 col-xs-height col-middle no-padding">
                                <div class="thumbnail-wrapper d32 circular inline">
                                    {*                                    <img width="32" height="32" src="{$baseUrl}Public/assets/img/profiles/2.jpg" data-src="{$baseUrl}Public/assets/img/profiles/2.jpg" data-src-retina="{$baseUrl}Public/assets/img/profiles/2x.jpg" alt="">*}
                                </div>
                                <div class="inline m-l-15">
                                    {*                                    <p class="text-white no-margin">Alex Nester</p>*}
                                    {*                                    <p class="hint-text text-white no-margin fs-12">Senior UI/UX designer</p>*}
                                </div>
                            </div>
                            <div class="col-xs-4 col-xs-height col-middle text-right  no-padding">
                                <h2 class="bold text-white price font-montserrat itemPrice"></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 p-r-35 p-t-35 p-l-35 full-height item-description">
                    <h2 class="semi-bold no-margin font-montserrat " id="itemTitle"></h2>
                    <span class="semi-bold no-margin font-montserrat" id="itemFormattedAddress"></span>
                    <p class="rating fs-12 m-t-5" id="itemRating">
                    </p>
                    <div class="row m-b-5 m-t-5 h3 " id="itemPriceLine">
                        <div class="col-xs-6"><span class="font-montserrat all-caps fs-11"></span>
                        </div>
                        <div class="col-xs-6 text-right itemPrice"  ></div>
                    </div>
                    {* Tittle
                    Date  H5
                    Price H3
                    Description
                    buttons
                    More filters*}
                    <p class="fs-13" id="itemDescription"></p>
                    {*                    <div class="row m-t-20 m-b-10">*}
                    {*                    <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Paint sizes</span>*}
                    {*                    </div>*}
                    {*                    </div>*}
                    {*<a href="#none" class="btn btn-white">S</a>
                    <a href="#none" class="btn btn-white">M</a>
                    <a href="#none" class="btn btn-white">L</a>
                    <a href="#none" class="btn btn-white">XL</a>*}
                    <div calss="item-buttons" style="float: right;position: absolute;bottom: 5px;width: 100%;">
                        <a href="#none" class="btn btn-primary" id="btnAddDream" url="explore" name="btnAddDream" event="click"><i class="fa fa-heart-o  "></i> Add to my dream board</a>
                        <br>
                        <br>
                        <a href="#none" class="btn btn-success " id="btnAddToTrip" name="btnAddToTrip" event="click" url='explore' ><i class="fa fa-plus  "></i> Add to a trip</a>

                    </div>

                </div>
            </div>
            <!--
    <div class="row dialog__footer bg-info-dark hidden-xs">
        <div class="col-sm-7 full-height separator">
            <div class="container-xs-height">
                <div class="row row-xs-height">
                    <div class="col-xs-7 col-xs-height col-middle no-padding">
                        <div class="thumbnail-wrapper d48 circular inline">
            {*                                    <img width="48" height="48" src="{$baseUrl}Public/assets/img/profiles/2.jpg" data-src="{$baseUrl}Public/assets/img/profiles/2.jpg" data-src-retina="{$baseUrl}Public/assets/img/profiles/2x.jpg" alt="">*}
        </div>
        <div class="inline m-l-15">
            {* <p class="text-white no-margin">Alex Nester</p>
            <p class="hint-text text-white no-margin fs-12">Senior UI/UX designer</p>*}
        </div>
    </div>
    <div class="col-xs-5 col-xs-height col-middle text-right  no-padding">
        <h2 class="bold text-white price font-montserrat itemPrice" >$20.00</h2>
    </div>
</div>
</div>
</div>
<div class="col-sm-5 full-height">
<ul class="recommended list-inline pull-right m-t-10 m-b-0">

            {section name=i loop=$placeLst max=3}
                <li>
                    <a href="#none"><img src="{$placeLst[i]->getPhotoPath()}"></a>
                </li>
            {/section}
        </ul>
    </div>
</div>
            -->

        </div>
        <a href="#none" class="close action top-right" data-dialog-close><i class="pg-close fs-14"></i>
        </a>
    </div>
</div>
<!-- END DIALOG -->


<!-- START ADD TO TRIP DIALOG -->
<div id="addToTripDialog" class="dialog item-details">
    <div class="dialog__overlay" name="btncloseaddtrip" event="click" url='explore'></div>
    <div class="dialog__content">
        <div class="container-fluid">
            <div class="row dialog__overview">
                <div class="col-sm-7 no-padding item-slideshow-wrapper full-height">
                    <div class="item-slideshow full-height itemGaleryNewTrip" id="itemDetailGaleryNewtrip">
                        <div class="slide" data-image="{$baseUrl}Public/Images/loading.gif">
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 p-r-35 p-t-35 p-l-35 full-height item-description">



                    <div class="widget-11-2 panel no-border panel-condensed no-margin widget-loader-circle">
                        <div class="padding-5">
                            <div class="pull-left">
                                <h2 class="semi-bold no-margin font-montserrat " id="itemTitleNewTrip"></h2>
                                <!-- <h4 class="text-success no-margin font-montserrat " id="itemTitleNewTrip">Place Title</h4> -->
                                <!-- <span class="semi-bold no-margin font-montserrat" id="itemFormattedAddressNewTrip">Place full address</span> -->
                                <!-- <h4 class="semi-bold no-margin font-montserrat ">Trip to add this place</h4> -->
                                <!-- <p class="no-margin">Trip to add this place</p> -->
                            </div>

                            <div class="clearfix"></div>
                        </div>
                        <div class="auto-overflow widget-11-2-table">
                            <table class="table table-condensed table-hover">
                                <tbody id="tripTable">

                                </tbody>
                            </table>
                        </div>
                        <div class="padding-25">
                            <p class="small no-margin">
                                <a href="#none" class="btn btn-success " id="btnAddToNewTrip" name="btnAddToNewTrip" event="click"><i class="fa fa-plus"></i> Add to a new trip</a>

                                <!-- <a href="#"><i class="fa fs-16 fa-arrow-circle-o-down text-success m-r-10"></i></a>
                                <span class="hint-text ">Show more details of APPLE . INC</span>
                                --></p>
                        </div>

                    </div>

                    <!--
                                        <div class="item-buttons" style="float: right;position: absolute;bottom: 5px;width: 100%;">
                                            <a href="#none" class="btn btn-success " id="btnAddToNewTrip" name="btnAddToNewTrip" event="click"><i class="fa fa-plus  "></i> Add to a new trip</a>
                                        </div>
                    -->                </div>
            </div>

        </div>
        <a href="#none" class="close action top-right" id="btncloseaddtrip" name="btncloseaddtrip"  event="click" url='explore' data-dialog-close><i class="pg-close fs-14"></i>
        </a>
    </div>
</div>
<!-- END DIALOG -->


<!-- Start FILTERS-->
<div class="quickview-wrapper" id="filters">
    <div class="padding-40 ">
        <a class="builder-close quickview-toggle pg-close" data-toggle="quickview" data-toggle-element="#filters" href="#none"></a>
        <form class="" role="form">
            <h5 class="all-caps font-montserrat fs-12 m-b-20">Advance filters</h5>
            <div class="form-group form-group-default ">
                <label>Place, activity or event</label>
                <input type="email" class="form-control" placeholder="Where to go?">
            </div>
            <h5 class="all-caps font-montserrat fs-12 m-b-20 m-t-25">Advance filters</h5>

            {$id_eventtype}
            <div class="radio radio-danger">
                <input type="radio" checked="checked" value="1" name="filter" id="asc">
                <label for="asc">Ascending order</label>
                <br>
                <input type="radio" value="2" name="filter" id="views">
                <label for="views">Most viewed</label>
                <br>
                <input type="radio" value="3" name="filter" id="cost">
                <label for="cost">Cost</label>
                <br>
                <input type="radio" value="4" name="filter" id="latest">
                <label for="latest">Latest</label>
            </div>
            <h5 class="all-caps font-montserrat fs-12 m-b-20 m-t-25">Price range</h5>
            <div class="bg-danger m-b-10" id="slider-margin">
            </div>
            <a href="#none" class="pull-right btn btn-danger btn-cons m-t-40">Apply</a>
        </form>
    </div>
</div>
<!-- END FILTERS -->

<div id="welcomemodal">
    <div class="modal fade fill-in" id="modalFillIn" tabindex="-1" role="dialog" aria-labelledby="modalFillInLabel" aria-hidden="true">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <i class="pg-close"></i>
        </button>
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>Welcome to Tumbleweed</h1>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center p-t-30">
                            <button type="button" class="btn btn-success btn-lg btn-large fs-15">How to use</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center p-t-20">
                            <button type="button" class="btn btn-primary btn-lg btn-large fs-15" data-dismiss="modal">Start Exploring</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<!-- JS -->
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
<script src="{$baseUrl}Public/assets/plugins/jquery-metrojs/MetroJs.min.js" type="text/javascript"></script>
<script src="{$baseUrl}Public/assets/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="{$baseUrl}Public/assets/plugins/jquery-isotope/isotope.pkgd.min.js" type="text/javascript"></script>
<script src="{$baseUrl}Public/assets/plugins/codrops-dialogFx/dialogFx.js" type="text/javascript"></script>
<script src="{$baseUrl}Public/assets/plugins/owl-carousel/owl.carousel.min.js" type="text/javascript"></script>{*
<script src="{$baseUrl}Public/assets/plugins/jquery-nouislider/jquery.nouislider.min.js" type="text/javascript"></script>
<script src="{$baseUrl}Public/assets/plugins/jquery-nouislider/jquery.liblink.js" type="text/javascript"></script>*}


<!-- BEGIN PAGE LEVEL JS -->
<script src="{$baseUrl}Public/assets/js/gallery.js" type="text/javascript"></script>
<script src="{$baseUrl}Public/assets/js/scripts.js" type="text/javascript"></script>
<!-- END PAGE LEVEL JS -->


{if $welcomemodal==true}
    {literal}
        <script type="text/javascript">
            $(document).ready(function () {
                $('#modalFillIn').modal('show');
            });
        </script>
    {/literal}
{/if}