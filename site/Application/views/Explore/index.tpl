

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

{literal}
    <style>

    </style>
{/literal}

<div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

    <!-- START CATEGORY -->
    <div class="gallery col-sm-12" style="">
        <!-- START ROW -->

        <div class="gallery-filters p-t-20 p-b-10">
            <ul class="list-inline text-right">
                <li class="col-md-6 col-sm-12">
                    {$search}
                    <span class="input-group-addon " style="display: none">
                        {$btnSearch}
                    </span>
                </li>
                <li class="hint-text">Sort by: </li>
                <li><a href="#" class="active text-master p-r-5 p-l-5">Places</a></li>
                <li><a href="#" class="text-master hint-text p-r-5 p-l-5">Activities</a></li>
                <li><a href="#" class="text-master hint-text p-r-5 p-l-5">Events</a></li>
                <li>  <a href="#"   class="btn btn-primary m-l-10" data-toggle="filters">More filters</a>                                              </li>
            </ul>
        </div>
        <!-- START GALLERY ITEM -->

        {section name=i loop=$activityLst}
            <!-- START GALLERY ITEM -->
            <!--
                  FOR DEMO PURPOSES, FIRST GALLERY ITEM (.first) IS HIDDEN
                  FOR SCREENS <920px. PLEASE REMOVE THE CLASS 'first' WHEN YOU IMPLEMENT
            -->
            <div class="gallery-item " data-id="{$activityLst[i]->getID()}"  event="click" name="galeryItem" params="id_activity={$activityLst[i]->getID()}" data-width="1" data-height="1">
                <!-- START PREVIEW -->
                <div class="live-tile slide" data-speed="750" data-delay="4000" data-mode="carousel">

                    {foreach from=$activityLst[i]->getPicsLst() name=galery item=item}
                        <div class="{if $smarty.foreach.galery.first}slide-front{else}slide-back{/if}">
                            <img src="{$item.src}" alt="" class="image-responsive-height">
                        </div>
                    {foreachelse}
                        <div class="slide-back">
                            <img src="{$baseUrl}Public/assets/img/gallery/2_1.jpg" alt="" class="image-responsive-height">
                        </div>
                    {/foreach}
                </div>
                <!-- END PREVIEW -->
                <!-- START ITEM OVERLAY DESCRIPTION -->
                <div class="overlayer bottom-left full-width">
                    <div class="overlayer-wrapper item-info more-content">
                        <div class="gradient-grey p-l-20 p-r-20 p-t-20 p-b-5">
                            <div class="">
                                <h3 class="pull-left bold text-white no-margin">{$activityLst[i]->getActivityName()}</h3>
                                <h3 class="pull-right semi-bold text-white font-montserrat bold no-margin">${$activityLst[i]->getPrice()}</h3>
                                <div class="clearfix"></div>
                                <span class="hint-text pull-left text-white">{$activityLst[i]->getDescription()|truncate:20:''}</span>
                                <div class="clearfix"></div>
                            </div>
                            <div class="">
                                <h5 class="text-white light">Most Sold Item in the marketplace</h5>
                            </div>
                            <div class="m-t-10">
                                <div class="thumbnail-wrapper d32 circular m-t-5">
                                    {*                                    <img width="40" height="40" src="{$baseUrl}Public/assets/img/profiles/avatar.jpg" data-src="{$baseUrl}Public/assets/img/profiles/avatar.jpg" data-src-retina="{$baseUrl}Public/assets/img/profiles/avatar2x.jpg" alt="">*}
                                </div>
                                <div class="inline m-l-10">
                                    {*<p class="no-margin text-white fs-12">Designed by Alex Nester</p>
                                    <p class="rating">
                                    <i class="fa fa-star rated"></i>
                                    <i class="fa fa-star rated"></i>
                                    <i class="fa fa-star rated"></i>
                                    <i class="fa fa-star rated"></i>
                                    <i class="fa fa-star"></i>
                                    </p>*}
                                </div>
                                <div class="pull-right m-t-10">
                                    <a href="#none" class="btn btn-white btn-xs btn-mini bold fs-14" type="button">+</a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PRODUCT OVERLAY DESCRIPTION -->
            </div>
            <!-- END GALLERY ITEM -->

        {/section}

        {section name=i loop=$eventLst}
            <!-- START GALLERY ITEM -->
            <!--
                  FOR DEMO PURPOSES, FIRST GALLERY ITEM (.first) IS HIDDEN
                  FOR SCREENS <920px. PLEASE REMOVE THE CLASS 'first' WHEN YOU IMPLEMENT
            -->
            <div class="gallery-item " data-id="{$eventLst[i]->getID()}"  event="click" name="galeryItem" params="id_event={$eventLst[i]->getID()}" data-width="1" data-height="1">
                <!-- START PREVIEW -->
                <div class="live-tile slide" data-speed="750" data-delay="4000" data-mode="carousel">

                    {foreach from=$eventLst[i]->getPicsLst() name=galery item=item}
                        <div class="{if $smarty.foreach.galery.first}slide-front{else}slide-back{/if}">
                            <img src="{$item.src}" alt="" class="image-responsive-height">
                        </div>
                    {foreachelse}
                        <div class="slide-back">
                            <img src="{$baseUrl}Public/assets/img/gallery/2_1.jpg" alt="" class="image-responsive-height">
                        </div>
                    {/foreach}
                </div>
                <!-- END PREVIEW -->
                <!-- START ITEM OVERLAY DESCRIPTION -->
                <div class="overlayer bottom-left full-width">
                    <div class="overlayer-wrapper item-info more-content">
                        <div class="gradient-grey p-l-20 p-r-20 p-t-20 p-b-5">
                            <div class="">
                                <h3 class="pull-left bold text-white no-margin">{$eventLst[i]->getEventName()}</h3>
                                <h3 class="pull-right semi-bold text-white font-montserrat bold no-margin">${$eventLst[i]->getPrice()}</h3>
                                <div class="clearfix"></div>
                                <span class="hint-text pull-left text-white">{$eventLst[i]->getDescription()|truncate:20:''}</span>
                                <div class="clearfix"></div>
                            </div>
                            <div class="">
                                <h5 class="text-white light">Most Sold Item in the marketplace</h5>
                            </div>
                            <div class="m-t-10">
                                <div class="thumbnail-wrapper d32 circular m-t-5">
                                    {*                                    <img width="40" height="40" src="{$baseUrl}Public/assets/img/profiles/avatar.jpg" data-src="{$baseUrl}Public/assets/img/profiles/avatar.jpg" data-src-retina="{$baseUrl}Public/assets/img/profiles/avatar2x.jpg" alt="">*}
                                </div>
                                <div class="inline m-l-10">
                                    {*<p class="no-margin text-white fs-12">Designed by Alex Nester</p>
                                    <p class="rating">
                                    <i class="fa fa-star rated"></i>
                                    <i class="fa fa-star rated"></i>
                                    <i class="fa fa-star rated"></i>
                                    <i class="fa fa-star rated"></i>
                                    <i class="fa fa-star"></i>
                                    </p>*}
                                </div>
                                <div class="pull-right m-t-10">
                                    <a href="#none" class="btn btn-white btn-xs btn-mini bold fs-14" type="button">+</a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PRODUCT OVERLAY DESCRIPTION -->
            </div>
            <!-- END GALLERY ITEM -->
        {/section}

    </div>
    <!-- END CATEGORY -->
</div>
<!-- START DIALOG -->
<div id="itemDetails" class="dialog item-details">
    <div class="dialog__overlay"></div>
    <div class="dialog__content">
        <div class="container-fluid">
            <div class="row dialog__overview">
                <div class="col-sm-7 no-padding item-slideshow-wrapper full-height">
                    <div class="item-slideshow full-height itemGalery" id="itemDetailGalery">
                        <div class="slide" data-image="{$baseUrl}Public/assets/img/gallery/item-square.jpg">
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
                                <h2 class="bold text-white price font-montserrat itemPrice">$20.00</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 p-r-35 p-t-35 p-l-35 full-height item-description">
                    <h2 class="semi-bold no-margin font-montserrat" id="itemTitle">Happy Ninja</h2>
                    <p class="rating fs-12 m-t-5">
                        <i class="fa fa-star "></i>
                        <i class="fa fa-star "></i>
                        <i class="fa fa-star "></i>
                        <i class="fa fa-star-o"></i>
                        <i class="fa fa-star-o"></i>
                    </p>
                    <p class="fs-13" id="itemDescription">When it comes to digital design, the lines between functionality, aesthetics, and psychology are inseparably blurred. Without the constraints of the physical world, there’s no natural form to fall back on, and every bit of constraint and affordance must be introduced intentionally. Good design makes a product useful.
                    </p>
                    <div class="row m-b-20 m-t-20">
                        <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Price ranges</span>
                        </div>
                        <div class="col-xs-6 text-right itemPrice"  >$20.00 - $40.00</div>
                    </div>
                    <div class="row m-t-20 m-b-10">
                        {*                    <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Paint sizes</span>*}
                        {*                    </div>*}
                    </div>
                    {*<a href="#none" class="btn btn-white">S</a>
                    <a href="#none" class="btn btn-white">M</a>
                    <a href="#none" class="btn btn-white">L</a>
                    <a href="#none" class="btn btn-white">XL</a>*}
                    <br>
                    <a href="#none" class="btn btn-primary " id="btnAddDream" name="btnAddDream" event="click"><i class="fa fa-heart-o fa-2x"></i> Add to My Dreams</a>
                </div>
            </div>
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
                        <li>
                            <a href="#"><img src="{$baseUrl}Public/assets/img/gallery/thumb-1.jpg"></a>
                        </li>
                        <li>
                            <a href="#"><img src="{$baseUrl}Public/assets/img/gallery/thumb-2.jpg"></a>
                        </li>
                        <li>
                            <a href="#"><img src="{$baseUrl}Public/assets/img/gallery/thumb-3.jpg"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <a href="#none" class="close action top-right" data-dialog-close><i class="pg-close fs-14"></i>
        </a>
    </div>
</div>
<!-- END DIALOG -->
<div class="quickview-wrapper" id="filters">
    <div class="padding-40 ">
        <a class="builder-close quickview-toggle pg-close" data-toggle="quickview" data-toggle-element="#filters" href="#"></a>
        <form class="" role="form">
            <h5 class="all-caps font-montserrat fs-12 m-b-20">Advance filters</h5>
            <div class="form-group form-group-default ">
                <label>Project</label>
                <input type="email" class="form-control" placeholder="Type of select a label">
            </div>
            <h5 class="all-caps font-montserrat fs-12 m-b-20 m-t-25">Advance filters</h5>
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
<script src="{$baseUrl}Public/assets/plugins/jquery-metrojs/MetroJs.min.js" type="text/javascript"></script>
<script src="{$baseUrl}Public/assets/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="{$baseUrl}Public/assets/plugins/jquery-isotope/isotope.pkgd.min.js" type="text/javascript"></script>
<script src="{$baseUrl}Public/assets/plugins/codrops-dialogFx/dialogFx.js" type="text/javascript"></script>
<script src="{$baseUrl}Public/assets/plugins/owl-carousel/owl.carousel.min.js" type="text/javascript"></script>
<script src="{$baseUrl}Public/assets/plugins/jquery-nouislider/jquery.nouislider.min.js" type="text/javascript"></script>
<script src="{$baseUrl}Public/assets/plugins/jquery-nouislider/jquery.liblink.js" type="text/javascript"></script>
<!-- BEGIN PAGE LEVEL JS -->
<script src="{$baseUrl}Public/assets/js/gallery.js" type="text/javascript"></script>
<script src="{$baseUrl}Public/assets/js/scripts.js" type="text/javascript"></script>
<!-- END PAGE LEVEL JS -->