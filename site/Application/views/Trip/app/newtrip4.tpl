

<h1>Adding {$tripname}</h1>
<h3>Ok, {$usuarioLogado}, where are you going to?</h3>
<p>(Multi city trip? don’t worry you can add another city/country later)</p>

<div class="row">
    {$search1}
</div>
<div class="row">
    <div class="col-sm-12 text-center">
        {$btnSearch1}
    </div>
</div>

<p> </p>

<div class="panel panel-transparent">

    <ul class="nav nav-tabs nav-tabs-linetriangle hidden-sm hidden-xs" data-init-reponsive-tabs="dropdownfx">
        <li {if !$dreamplacesempty} class="active"{/if} id="dreamboardtabcontrol">
            <a data-toggle="tab" href="#dreamboardtab"><span>Dreamboard</span></a>
        </li>
        <li {if $dreamplacesempty} class="active"{/if} id="exploretabcontrol">
            <a data-toggle="tab" href="#exploretab"><span>Explore</span></a>
        </li>
    </ul>
    <div class="tab-content" name="defaultplaces">
        <div class="tab-pane {if !$dreamplacesempty}active{/if}" id="dreamboardtab">
            <div id="dreamboarddiv" class="col-md-12">{$dreamboarddiv}</div>
        </div>
        <div class="tab-pane {if $dreamplacesempty}active{/if}" id="exploretab">
            <div id="placesdiv" class="col-md-12">{$placesdiv}</div>
        </div>
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
                                </div>
                                <div class="inline m-l-15">
                                </div>
                            </div>
                            <div class="col-xs-4 col-xs-height col-middle text-right  no-padding">
                                <h2 class="bold text-white price font-montserrat itemPrice"></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 p-r-35 p-t-35 p-l-35 full-height item-description">
                    <h2 class="semi-bold no-margin font-montserrat" id="itemTitle"></h2>
                    <span class="semi-bold no-margin font-montserrat" id="itemFormattedAddress"></span>
                    <p class="rating fs-12 m-t-5" id="itemRating">
                    </p>
                    <p class="fs-13" id="itemDescription">
                    </p>
                    <div class="row m-b-5 m-t-5 " id="itemPriceLine">
                        <div class="col-xs-6"><span class="font-montserrat all-caps fs-11"></span>
                        </div>
                        <div class="col-xs-6 text-right itemPrice"  ></div>
                    </div>
                    <a href="#none" class="btn btn-primary" id="btnAddDream" name="btnAddDream" url="explore" event="click"><i class="fa fa-heart-o  "></i> to my Dreams</a>
                    <br>
                    <a href="#none" class="btn btn-success " id="btnAddToTrip" name="newtripcity" event="click"><i class="fa fa-plus  "></i> <span style="font-weight: bold"id="itemCountry"></span> to this trip!</a>
                </div>
            </div>
            <div class="row dialog__footer bg-info-dark hidden-xs">
                <div class="col-sm-7 full-height separator">
                    <div class="container-xs-height">
                        <div class="row row-xs-height">
                            <div class="col-xs-7 col-xs-height col-middle no-padding">
                                <div class="thumbnail-wrapper d48 circular inline">
                                </div>
                                <div class="inline m-l-15">
                                </div>
                            </div>
                            <div class="col-xs-5 col-xs-height col-middle text-right  no-padding">
                                <h2 class="bold text-white price font-montserrat itemPrice" ></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 full-height">
                    <ul class="recommended list-inline pull-right m-t-10 m-b-0">

                        {section name=i loop=$placeLst max=3}
                            <li>
                                <a href="#"><img src="{$placeLst[i]->getPhotoPath()}"></a>
                            </li>
                        {/section}
                    </ul>
                </div>
            </div>
        </div>
        <a href="#none" class="close action top-right" data-dialog-close><i class="pg-close fs-14"></i>
        </a>
    </div>
</div>
<!-- END DIALOG -->


<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsL2HI8bxi78DT4oHVw1XTOT4qKjksPi0&libraries=places"></script>

{literal}
    <script type="text/javascript">

        var defaultBounds = new google.maps.LatLngBounds(
                new google.maps.LatLng(-90, -180),
                new google.maps.LatLng(90, 180));
        var options = {
            bounds: defaultBounds,
            types: ['(cities)']
        };

        var input = document.getElementById('search1');

        var searchBox = new google.maps.places.SearchBox(input, options);

        searchBox.addListener('places_changed', function () {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            var bounds = new google.maps.LatLngBounds();
            places.forEach(function (place) {
                if (!place.geometry) {
                    document.getElementById('google_place_id').value = '';
                    document.getElementById('lat').value = '';
                    document.getElementById('lng').value = '';
                    return;
                }
                document.getElementById('google_place_id').value = place.id;
                document.getElementById('lat').value = place.geometry.location.lat();
                document.getElementById('lng').value = place.geometry.location.lng();
            });
        });

    </script>

{/literal}