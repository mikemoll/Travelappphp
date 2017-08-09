{literal}
    <style>
        .widget-1:after{
            background-image: url(http://www.ladyhattan.com/wp-content/uploads/2014/03/Eiffel-Tower-Paris-France.jpg) !important;
        }
        .widget-0:after{
            background-image: url(http://az608707.vo.msecnd.net/files/Torcross_EN-US9088790716_1366x768.jpg) !important;
        }
    </style>
{/literal}

{literal}
    <style>
        .gallery-item2{
            cursor:pointer;
        }
        .box-item{
            margin-bottom: 20px;
        }
        #itemDescription{
            height: 300px;
            overflow-y: auto;
            width: 314px;
        }
        .item-details .dialog__content .dialog__footer .recommended li img {
            width: 100%;
            height: 100%;
            display: block;
            overflow: hidden;
        }
        .old-trip {
            display: block;
            float: right;
        }
    </style>
{/literal}
<div class="row">
    <div class="col-sm-6">
        <h1>My Trips</h1>
    </div>
    <div class="col-sm-6" align="right">
        <a href="{$btnOldTripHref}" target="_self" class="btn btn-success btn-cons">{$btnOldTripText}</a>
    </div>
</div>

<!-- START ROW -->
<div class="col-sm-3 m-b-4">
    <div class="ar-1-1">
        <!-- START WIDGET widget_plainWidget-->
        <div class="panel no-border bg-master widget widget-0 widget-loader-circle-lg no-margin">
            <div class="panel-heading">
                <div class="panel-controls">
                    <ul>
                        <li><a data-toggle="refresh" class="portlet-refresh" href="#"><i class="portlet-icon portlet-icon-refresh-lg-white"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
{*                <a href="{$HTTP_REFERER}trip/newtrip">*}
                <a href="{$HTTP_REFERER}trip/newtrip">
                    <div class="pull-bottom bottom-left bottom-right padding-25">
                        <h1 class="text-white semi-bold">New Trip!</h1>
                        <span class="label font-montserrat fs-11">Click here to start!</span>
                        <p class="text-white m-t-20">Feels like a good day to travel!</p>
                        {*                        <p class="text-white hint-text m-t-30">July 2017, 15 Saturday </p>*}
                    </div>
                </a>
            </div>
        </div>
        <!-- END WIDGET -->
    </div>
</div>


{section name=i loop=$tripLst}

    {literal}
        <style>
            .trip-{/literal}{$tripLst[i]->getID()}{literal}:after{
                background-image: url({/literal}{$tripLst[i]->getFirstPhoto()}{literal}) !important;
            }
        </style>
    {/literal}
    <div class="col-md-4 col-xlg-4 box-item" >
        <div class="ar-1-1">

            <!-- START WIDGET widget_imageWidgetBasic-->
            <div class="widget-2 panel no-border bg-primary widget widget-loader-circle-lg no-margin trip-{$tripLst[i]->getID()}">
                <div class="panel-heading">
                    <div class="panel-controls">
                        <ul>
                            <li><a href="{$HTTP_REFERER}trip/edit/id/{$tripLst[i]->getID()}/{$tripLst[i]->getTripName()}" title="Open this trip!" class="label">edit</a></li>
                            <li>
                                {* <a class="widget-3-fav no-decoration" style="{if $tripLst[i]->getFavorite()!=''}display: none;{/if}" href="#" id="btnadddream"
                                name="btnadddream"  event="click" url="explore"
                                params="id_trip={$tripLst[i]->getID()}">
                                <i class="fa fa-heart-o fa-2x" style="color: red"></i>
                                </a>
                                <a class="widget-3-fav no-decoration" style="{if $tripLst[i]->getFavorite()==''}display: none;{/if}" href="#" id="btnremovedream"
                                name="btnremovedream"  event="click" url="explore"
                                params="id_trip={$tripLst[i]->getID()}">
                                <i class="fa fa-heart fa-2x" style="color: red"></i>
                                </a>*}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body gallery-item2" data-id="{$tripLst[i]->getID()}" params="id_trip={$tripLst[i]->getID()}&google_trip_id={$tripLst[i]->getgoogle_trip_id()}">

                    <a href="{$HTTP_REFERER}trip/detail/id/{$tripLst[i]->getID()}/{$tripLst[i]->getTripName()}" title="Open this trip!">
                        <div class="pull-bottom bottom-left bottom-right padding-15">
                            <span class="label font-montserrat fs-11">Trip</span>
                            <br>
                            <h3 class="text-white">{$tripLst[i]->getTripName()}</h3>
                            {if $tripLst[i]->gettravelmethod()!=''}
                                <p class="text-white hint-text hidden-md">Traveling by {$tripLst[i]->gettravelmethod()}</p>
                            {/if}
                            {*                            <p class="text-white hint-text hidden-md">${$tripLst[i]->getPrice()}</p>*}
                            <div class="row stock-rates m-t-15">
                                <div class="company col-xs-4">
                                    <div>
                                        <p class="bold text-white no-margin fs-11 font-montserrat lh-normal">
                                            Check In
                                        </p>
                                        <p class="font-montserrat text-success no-margin fs-16">
                                            <i class="fa fa-caret-up"></i> {$tripLst[i]->getformatedstartdate()}<br><small>{$tripLst[i]->getDaysToText()}</small>
                                            {*                                                    <span class="font-arial text-white fs-12 hint-text m-l-5">546.45</span>*}
                                        </p>
                                    </div>
                                </div>
                                <div class="company col-xs-4">
                                    <div>
                                        <p class="bold text-white no-margin fs-11 font-montserrat lh-normal">
                                            Check Out
                                        </p>
                                        <p class="font-montserrat text-danger no-margin fs-16">
                                            <i class="fa fa-caret-down"></i> {$tripLst[i]->getformatedenddate()}
                                            {*                                                    <span class="font-arial text-white fs-12 hint-text m-l-5">345.34</span>*}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- END WIDGET -->
        </div>

    </div>
{/section}

