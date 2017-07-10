<div class="row">
    <div class="col-lg-4">
        <h2>{$TituloPagina}</h2>
    </div>
    <div class="col-lg-8">
        <br>
        {$public}
    </div>
</div>
<input type="hidden" autofocus="true" />
<div class="row">
    <div class="col-lg-8">

        <!-- LINHA 1  -->
        <div class="row">
            <div class="col-lg-8">
                {$eventname}
            </div>
            <div class="col-lg-4">
                {$id_eventtype}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                {$start_at}
            </div>
            <div class="col-lg-6">
                {$end_at}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                {$description}
            </div>
            <div class="col-lg-6">
                {$eventsupply}
            </div>
        </div>

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
        <div class="row">
            <div class="col-lg-3">
                {$lat}
            </div>
            <div class="col-lg-3">
                {$lng}
            </div>
            <div class="col-lg-3">
                {$geoloc}
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <h3>
            Invited users to this Event
        </h3>
        {$btnInvite}
        {$gridUser}
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        {$btnSave} {$btnCancel}
    </div>
</div>
