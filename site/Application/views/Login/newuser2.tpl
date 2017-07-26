<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsL2HI8bxi78DT4oHVw1XTOT4qKjksPi0&libraries=places"></script>
<h1 class="light">{$firstname}, Welcome to<br>Tumbleweed</h1>
<h3 class="light">We’re going to help you create your greatest travel memories.</h3>
<h5>Lets set up your profile first.</h5>
<h1>Step 1 of 2</h1>
<h5>Where is home base?</h5>
<div class="form-group form-group-default col-md-12">
    <div class="no-padding">
        <label>Home Town</label>
        <div class="controls">
            {$hometowncity}
        </div>
    </div>
</div>
<!-- 
<div class="form-group form-group-default col-md-12">
    <div class=" no-padding">
        <label>Home Country</label>
        <div class="controls">
            {$hometowncountry}
        </div>
    </div>
</div> -->
{$btnSkip2}
{$btnContinue2}

<!-- <img class="p-t-100" src="{$baseUrl}Public/Images/google.png" alt="Powered by Google" title="Powered by Google" /> -->



{literal}
<script type="text/javascript">

    var defaultBounds = new google.maps.LatLngBounds(
    new google.maps.LatLng(-33.8902, 151.1759),
    new google.maps.LatLng(-33.8474, 151.2631));

    var input = document.getElementById('hometowncity');

    var searchBox = new google.maps.places.SearchBox(input, {
      bounds: defaultBounds
    });


</script>

{/literal}
