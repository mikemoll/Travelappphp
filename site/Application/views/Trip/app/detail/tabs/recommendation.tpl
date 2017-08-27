<div class="row m-b-20">
{if $public}
    <a class="btn btn-success" href="{$baseUrl}web/addrecommendation/p/{$pubUrl}"><i class="fa fa-plus"></i> &nbsp Add a recommendation</a>
{else}
    <a class="btn btn-facebook" id="share_fb" href="{$HTTP_HOST}{$baseUrl}web/triprecommendation/p/{$pubUrl}"><i class="fa fa-facebook"></i> &nbsp Ask for recommendations on Facebook</a>
    {literal}
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId            : '259150917920223',
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v2.10'
            });
            FB.AppEvents.logPageView();
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        document.getElementById("share_fb").addEventListener("click",function(event){
            FB.ui({
                method: 'share',
                mobile_iframe: true,
                href: '{/literal}{$HTTP_HOST}{$baseUrl}web/triprecommendation/p/{$pubUrl}{literal}',
            }, function(response){});
            event.preventDefault();
            return false;
        });

    </script>
    {/literal}
    {* <a class="btn btn-success" href="{$baseUrl}web/triprecommendation/p/{$pubUrl}">See the Public Recommendation page</a> *}
{/if}
{if $showMap eq 'true'}
    <a class="btn btn-secondary" href="{$UrlMapToogle}" role="button"><i class="fa fa-map-marker"></i> &nbsp Hide map</a>
{else}
    <a class="btn btn-secondary" href="{$UrlMapToogle}" role="button"><i class="fa fa-map-marker"></i> &nbsp Show map</a>
{/if}
</div>

{if $showMap eq 'true'}
<div class="row">
    <div class="col-md-5">
        {literal}
        <style>
            #map {
                height: 550px;
                width: 100%;
            }
        </style>
        <script>
            var locations = [
                {/literal}
                    {section name=i loop=$RecommendationLst}
                        {if $RecommendationLst[i]->getLat() neq ''}
                            ['{$RecommendationLst[i]->getLocation()}', {$RecommendationLst[i]->getLat()}, {$RecommendationLst[i]->getLng()}],
                        {/if}
                    {/section}
                {literal}
            ];



            function initMap() {

                // If there is no location show Vancouver;
                if (locations.lenght == 0) {
                    locations = ['Vancouver, BC, Canada',49.28272910, -123.12073750];
                }

                // Create the map
                var map = new google.maps.Map(document.getElementById('map'), {});

                // Create a info windows for the markers
                var infowindow = new google.maps.InfoWindow();

                // Create the markers and the bounds
                var marker, i;
                var latlngbounds = new google.maps.LatLngBounds();
                for (i = 0; i < locations.length; i++) {

                    latLng = new google.maps.LatLng(locations[i][1], locations[i][2]);
                    latlngbounds.extend(latLng);

                    marker = new google.maps.Marker({
                        position: latLng,
                        map: map
                    });

                    google.maps.event.addListener(marker, 'click', (function (marker, i) {
                        return function () {
                            infowindow.setContent(locations[i][0]);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                }

                map.setCenter(latlngbounds.getCenter());
                map.fitBounds(latlngbounds); 


            }
        </script>
        {/literal}
        <div id="map"></div>
        <!-- Replace the value of the key parameter with your own API key. -->
        <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAogLeuY-9AsskizliKja8jFSvYoZh-Ry0&libraries=places&callback=initMap">
        </script>
    </div>
    <div class="col-md-7">
{/if}
        <div class="row">
            {section name=i loop=$RecommendationLst}
                <div class="card padding-20">
                    <div class="row">
                        <span class="label font-montserrat fs-11">{ $RecommendationLst[i]->getDecodedType()}</span>
                        {if $RecommendationLst[i]->getType() neq 'P'}
                            <span class="label font-montserrat fs-11 text-white purple">{ $RecommendationLst[i]->activityOrEventTypeName()}</span>
                        {/if}
                        <span class="pull-right">{ $RecommendationLst[i]->formattedCost()}</span>
                    </div>

                    <div>
                        <h3 class="unique-line m-b-0">{ $RecommendationLst[i]->getTitle() }</h3>
                    </div>
                    <div>
                        <p class="unique-line small-text"><i class="fa fa-map-marker"></i> { $RecommendationLst[i]->getLocation() }</p>
                    </div>
                    <div class="scroll-box-150">
                        <p>{ $RecommendationLst[i]->getNotes() } - {$showMap}</p>
                    </div>
                    <p class="unique-line"><b>Recommended by { $RecommendationLst[i]->getFriendfullname() }</b></p>
                    {if not $public}
                    <a class="btn btn-default" href="#" role="button"><i class="fa fa-plus"></i> &nbsp Add to itinerary</a>
                    {/if}
                </div>
            {/section}

        </div>
{if $showMap eq 'true'}
    </div>
</div>
{/if}