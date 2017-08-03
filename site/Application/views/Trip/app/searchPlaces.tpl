

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
    </style>
{/literal}



{section name=i loop=$placeLst}
    {if $onlyDreamplaces==false || $placeLst[i]->getFavorite()!=''}
    {literal}
        <style>
            .place-{/literal}{$placeLst[i]->getID()}{literal}:after{
                background-image: url({/literal}{$placeLst[i]->getPhotoPath()}{literal}) !important;
            }
        </style>
    {/literal}
    <div class="col-md-4 col-xlg-4 box-item" >
        <div class="ar-1-1">
            <!-- START WIDGET widget_imageWidgetBasic-->
            <div class="widget-2 panel no-border bg-primary widget widget-loader-circle-lg no-margin place-{$placeLst[i]->getID()}">
                <div class="panel-heading">
                    <div class="panel-controls">
                        <ul>
                            <li>
                                <a class="widget-3-fav no-decoration" style="{if $placeLst[i]->getFavorite()!=''}display: none;{/if}" href="#" id="btnadddream"
                                   name="btnadddream"  event="click" url="explore"
                                   params="id_place={$placeLst[i]->getID()}">
                                    <i class="fa fa-heart-o fa-2x" style="color: red"></i>
                                </a>
                                <a class="widget-3-fav no-decoration" style="{if $placeLst[i]->getFavorite()==''}display: none;{/if}" href="#" id="btnremovedream"
                                   name="btnremovedream"  event="click" url="explore"
                                   params="id_place={$placeLst[i]->getID()}">
                                    <i class="fa fa-heart fa-2x" style="color: red"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body gallery-item2" data-id="{$placeLst[i]->getID()}"  event="click" name="galeryItem" url='explore'   params="id_place={$placeLst[i]->getID()}&google_place_id={$placeLst[i]->getgoogle_place_id()}&id_trip={$id_trip}">
                    <div class="pull-bottom bottom-left bottom-right padding-15">
                        <span class="label font-montserrat fs-11">Place</span>
                        <br>
                        <h3 class="text-white">{$placeLst[i]->getName()}</h3>
                        {if $placeLst[i]->getFormatted_Address()!=''}
                            <p class="text-white hint-text hidden-md">{$placeLst[i]->getFormatted_Address()}</p>
                        {/if}
                        {*                        <p class="text-white hint-text hidden-md">${$placeLst[i]->getPrice()}</p>*}
                    </div>
                </div>
            </div>
            <!-- END WIDGET -->
        </div>

    </div>
    {/if}
{sectionelse}
<p> {$nothingfoundmsg}</p>
{/section}

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