<div id="general" class="collapse slide-up in">
    <div class="row">
        <div class="h4  text-center">
            Add an Activity to your Trip
        </div>
    </div>
    <input type="hidden" autofocus="true" />
    <!-- LINHA 1  -->
    <div class="row">
        <div class="col-lg-6">
            {$activityname}
        </div>
        <div class="col-lg-3">
            {$id_activitytype}
        </div>
        <div class="col-lg-3">
            {$start_at}
        </div>
        <div class="row">
            <div class="col-lg-6">
                {$description}
            </div>
            <div class="col-lg-6">
                {$activitysupply}
            </div>
        </div>
        <div class="row " >
            <a href="#advanced" data-toggle="collapse">Show advanced options</a>
        </div>
    </div>
    <div id="advanced" class="collapse slidedown">

        <div class="row">
            <div class="col-lg-6">
                {$id_currency}
            </div>
            <div class="col-lg-6">
                {$price}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                {$address}
            </div>
            <div class="col-lg-4">
                {$city}
            </div>
            <div class="col-lg-4">
                {$country}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                {$dresscode}
            </div>
        </div>
    </div>

    <div class="row text-center">
        <div class="col-md-12">
            {$btnSaveTripActivity}
            {$btnClose}
        </div>
    </div>
</div>