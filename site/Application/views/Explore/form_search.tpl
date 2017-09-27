<div class="row p-t-10 " style="">
    <div class="pull-left " style="width: 75%;">
        {$search2}
    </div>
    <div class="pull-left">
        {$btnSearch}
        {$btnFeelingLucky}
    </div>
</div>


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

        var input = document.getElementById('search2');

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