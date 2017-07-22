<div class="row full-height no-margin" >
    <div class="col-md-3 no-padding b-r b-grey sm-b-b full-height">
        <div class="full-height">
            <!-- BEGIN Profile View  !-->
            <div style="padding-right: 20px;">
                <span class="col-xs-height col-middle" >
                    <span class="thumbnail-wrapper circular bg-success" style="">
                        <img width="34" height="34" alt="" data-src-retina="{$Photo}" data-src="{$Photo}" src="{$Photo}" class="col-top">
                    </span>
                </span>
            </div>
            <div>
                <h2 class="fs-12">{$name}</span></h2>
                <p class="fs-12"><i class="fa fa-map-marker"></i> Living in {$livein}</span></p>
                <p class="fs-12">Bio: {$bio}</p>

                <p align="center">
                    {foreach from=$interests item=it}
                        <img alt="{$it.name}" title="{$it.name}" src="{$it.icon}" style="max-height: 50px; max-width: 50px;"/>
                    {/foreach} &nbsp;
                    {foreach from=$travelertypes item=it}
                        <img alt="{$it.name}" title="{$it.name}" src="{$it.icon}" style="max-height: 50px; max-width: 50px;"/>
                    {/foreach}
                </p>
                <p class="fs-12">Traveled to:<br> <span>{$traveledto}</span></p>
                <p class="fs-12">Hometown: <span class="fs-12">{$hometown}</span></p>
                <p class="fs-12">Relationship: <span class="fs-12">{$relationship}</span></p>
                <p class="fs-12">Education: <span class="fs-12">{$education}</span></p>
                <p class="fs-12">Occupation: <span class="fs-12">{$occupation}</span></p>
                <p class="fs-12">Dreamjob: <span class="fs-12">{$dreamjob}</span></p>
                <p align="center">
                    <a class="btn btn-primary" type="button" href="https://facebook.com/{$facebook}" target="_blank">
                        <span class="pull-left"><i class="fa fa-facebook"></i></span>
                    </a>
                    <a class="btn btn-complete" type="button" href="https://twitter.com/{$twitter}" target="_blank">
                        <span class="pull-left"><i class="fa fa-twitter"></i></span>
                    </a>
                    <a class="btn btn-info" type="button" href="https://instagram.com/{$instagram}" target="_blank">
                        <span class="pull-left"><i class="fa fa-instagram"></i></span>
                    </a>
                </p>
                <p> </p>
                {if $myprofile eq TRUE}
                    <p align="center"><a class="btn btn-warning" type="button" href="{$baseUrl}usuario/profileedit">Edit Profile</a></p>
                {/if}
            </div>
            <!-- END Profile View  !-->
        </div>
    </div>
    <div class="col-md-9 no-padding full-height">
        <div class="placeholder full-height">
            <!-- BEGIN Header  !-->

            <div class="panel panel-transparent">

                <ul class="nav nav-tabs nav-tabs-linetriangle hidden-sm hidden-xs" data-init-reponsive-tabs="dropdownfx">
                    <li class="active">
                        <a data-toggle="tab" href="#home" aria-expanded="true"><span>Map</span></a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#profile" aria-expanded="false"><span>Dreamboard</span></a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#messages" aria-expanded="false"><span>My Trips</span></a>
                    </li>
                </ul><div class="nav-tab-dropdown cs-wrapper full-width p-t-10 visible-xs visible-sm"><div class="cs-select cs-skin-slide full-width" tabindex="0"><span class="cs-placeholder">Hello World</span><div class="cs-options"><ul><li data-option="" data-value="#home"><span>Hello World</span></li><li data-option="" data-value="#profile"><span>Hello Two</span></li><li data-option="" data-value="#messages"><span>Hello Three</span></li></ul></div><select class="cs-select cs-skin-slide full-width" data-init-plugin="cs-select"><option value="#home" selected="">Hello World</option><option value="#profile">Hello Two</option><option value="#messages">Hello Three</option></select><div class="cs-backdrop"></div></div></div>

                <div class="tab-content">
                    <div class="tab-pane active " id="home">
                        {*                        <div class="row column-seperation">*}
                        {* <div class="full-width col-middle text-center">
                        <h1 >Go Everywhere</h1>
                        <p align="center">Keep track of all the places you have been</p>
                        <p align="center">Set a goal and challenge yourself</p>
                        <p align="center">Compete with your friends and travel buddies</p>
                        <p align="center">Can you make it to the top of the global leader board?</p>
                        </div>*}






                        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />

                        <link href="{$baseUrl}Public/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
                        <link href="{$baseUrl}Public/assets/plugins/bootstrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
                        <link href="{$baseUrl}Public/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
                        <link href="{$baseUrl}Public/assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" media="screen" />
                        <link href="{$baseUrl}Public/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" media="screen" />
                        <link href="{$baseUrl}Public/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
                        <link href="{$baseUrl}Public/assets/plugins/mapplic/css/mapplic.css" rel="stylesheet" type="text/css" />
                        <link href="{$baseUrl}Public/pages/css/pages-icons.css" rel="stylesheet" type="text/css">
                        <link class="main-stylesheet" href="{$baseUrl}Public/pages/css/pages.css" rel="stylesheet" type="text/css" />
                        <!--[if lte IE 9]>
                            <link href="{$baseUrl}Public/assets/plugins/codrops-dialogFx/dialog.ie.css" rel="stylesheet" type="text/css" media="screen" />
                            <![endif]-->
                        <!-- BEGIN SIDEBPANEL-->

                        <!-- END SIDEBAR -->
                        <!-- END SIDEBPANEL-->
                        <!-- START PAGE-CONTAINER -->
                        <div class="" style="height: 500px">
                            <!-- START HEADER -->
                            <div class="map-container full-width full-height relative">
                                <div class="map-controls">
                                    <div class="pull-left">
                                        <div class="btn-group btn-group-vertical" data-toggle="buttons-radio">
                                            <button class="btn btn-xs"><i class="fa fa-plus"></i>
                                            </button>
                                            <button class="btn btn-xs"><i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <br>
                                        <a href="#" class="btn btn-xs m-t-10 clear-map">
                                            <i class="fa fa-arrows"></i>
                                        </a>
                                    </div>
                                   {* <div class="pull-left m-l-15">
                                        <form role="form">
                                            <div class="form-group form-group-default form-group-default-select2">
                                                <label>Country</label>
                                                <select id="country-list" data-placeholder="Search by locationg, tag, ID" data-init-plugin="select2">
                                                </select>
                                            </div>
                                        </form>
                                    </div>*}
                                </div>
                                <div id="mapplic"></div>
                            </div>
                        </div>
                        <!-- END PAGE CONTAINER -->
                        <!--START QUICKVIEW -->

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
                        <script src="{$baseUrl}Public/assets/plugins/mapplic/js/hammer.js"></script>
                        <script src="{$baseUrl}Public/assets/plugins/mapplic/js/jquery.mousewheel.js"></script>
                        <script src="{$baseUrl}Public/assets/plugins/mapplic/js/mapplic.js"></script>
                        <!-- END VENDOR JS -->
                        <!-- BEGIN CORE TEMPLATE JS -->
                        <script src="{$baseUrl}Public/pages/js/pages.min.js"></script>
                        <!-- END CORE TEMPLATE JS -->
                        <!-- BEGIN PAGE LEVEL JS -->
                        <script src="{$baseUrl}Public/assets/js/vector_map.js" type="text/javascript"></script>
                        <script src="{$baseUrl}Public/assets/js/scripts.js" type="text/javascript"></script>
                        <!-- END PAGE LEVEL JS -->



                    </div>
                    <div class="tab-pane  fade" id="profile">
                        <div class="row">

                            {section name=i loop=$dreams}

                                {literal}<style>
                                        .dream-{/literal}{$dreams[i]->getID()}{literal}:after{
                                            background-image: url({/literal}{$dreams[i]->getPhotoPath()}{literal}) !important;
                                        }
                                    </style>
                                {/literal}

                                <div class="col-md-3 col-xlg-3 m-b-20">
                                    <div class="ar-1-1">
                                        <!-- START WIDGET widget_imageWidgetBasic-->
                                        <div class="widget-2 panel no-border bg-primary widget widget-loader-circle-lg no-margin dream-{$dreams[i]->getID()}">
                                            <div class="panel-heading">
                                                <div class="panel-controls">
                                                    <ul>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="panel-body gallery-item2" data-id="3" event="click" name="galeryItem" url="explore" params="id_activity=3">
                                                <div class="pull-bottom bottom-left bottom-right padding-15">
                                                    <h3 class="text-white">{$dreams[i]->getName()}</h3>
                                                    <p class="text-white hint-text hidden-md">{$dreams[i]->getAddress()}</p>
                                                    {*                                                        <h3 class="text-white hidden-md  bold">$21.75</h3>*}
                                                    <span class="label font-montserrat fs-11">{$dreams[i]->getType()}</span>
                                                    {*                                                        <span class="label font-montserrat fs-11 text-white " style="background-color: #FF50FF;  ">Art Gallery</span>*}
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END WIDGET -->
                                    </div>

                                </div>

                            {/section}
                        </div>
                    </div>
                    <div class="tab-pane  fade" id="messages">
                        <div class="row">
                            {section name=i loop=$tripLst}

                                {literal}
                                    <style>
                                        .trip-{/literal}{$tripLst[i]->getID()}{literal}:after{
                                            background-image: url({/literal}{$tripLst[i]->getFirstPhoto()}{literal}) !important;
                                        }
                                    </style>
                                {/literal}
                                <div class="col-md-4 col-xlg-4 m-b-10" >
                                    <div class="ar-1-1">

                                        <!-- START WIDGET widget_imageWidgetBasic-->
                                        <div class="widget-2 panel no-border bg-primary widget widget-loader-circle-lg no-margin trip-{$tripLst[i]->getID()}">
                                            <div class="panel-heading">
                                                <div class="panel-controls">
                                                    <ul>
                                                        {*                                                        <li><a href="edit/id/{$tripLst[i]->getID()}/{$tripLst[i]->getTripName()}" title="Open this trip!" class="label">edit</a></li>*}
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
                                                        {*                                                        <span class="label font-montserrat fs-11">Trip</span>*}
                                                        {*                                                        <br>*}
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
                                                                        {$tripLst[i]->getstartdate()}<br><small>in {$tripLst[i]->getDaysTo()} days!</small>
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
                                                                        {$tripLst[i]->getenddate()}
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
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>