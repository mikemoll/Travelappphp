
<h1>Adding a recommendation of a</h1>
<p id="msg">{$msg}</p>

<div class="row">
    <div class="col-md-6 form-group">
        <label></label>
        <div class="radio radio-success">
            <input type="radio" value="P" name="type" id="typep" checked>
            <label for="typep"> Place to visit</label>

            <input type="radio" value="A" name="type" id="typea">
            <label for="typea"> Activity to do</label>

            <input type="radio" value="E" name="type" id="typee">
            <label for="typee"> Event to go</label>
        </div>
    </div>
    <div id="id_activitytype" class="col-md-6 hidden">
        {$id_activitytype}
    </div>
    <div id="id_eventtype" class="col-md-6 hidden">
        {$id_eventtype}
    </div>
    <div id="start_at" class="col-md-3 hidden">
        {$start_at}
    </div>
    <div id="end_at" class="col-md-3 hidden">
        {$end_at}
    </div>
        {$google_place_id}
        {$lat}
        {$lng}
</div>
<div class="row">
    <div class="col-md-12">
        {$title}
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        {$location}
    </div>
    <div class="col-xs-5 col-md-3">
        {$cost}
    </div>
    <div class="col-xs-4 col-md-2">
        {$id_currency}
    </div>
    <div class="col-xs-3 col-md-1">
        {$isfree}
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        {$notes}
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        {$friendfullname}
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        {$btnSaveRecommendation} {$btnCancel}
    </div>
</div>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsL2HI8bxi78DT4oHVw1XTOT4qKjksPi0&libraries=places"></script>

{literal}
<script type="text/javascript">

    var defaultBounds = new google.maps.LatLngBounds(
                                new google.maps.LatLng(-90, -180),
                                new google.maps.LatLng(90, 180));
    var options =   {
                      bounds: defaultBounds,
                      types: ['(cities)']
                    };

    var input = document.getElementById('location');

    var searchBox = new google.maps.places.SearchBox(input,options);

    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
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



