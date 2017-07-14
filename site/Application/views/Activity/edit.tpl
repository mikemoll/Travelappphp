
<input type="hidden" autofocus="true" />
<!-- LINHA 1  -->
<div class="row">
    <div class="col-lg-3">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>

        <div class="form-group form-group-default col-md-12 text-center">

            <div class="fileinput fileinput-new" data-provides="fileinput" style="height: 174px;">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 125px;">
                    <img data-src="{$PhotoPath}" alt="Click to change the photo">
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 195px; max-height: 125px;"></div>
                <div>
                    <span class="btn btn-default btn-file"><span class="fileinput-new">Change image</span><span class="fileinput-exists">Change image</span><input type="file" name="Photo"></span>
                </div>
            </div>

        </div>
    </div>
    <div class="col-lg-9">

        <div class="col-lg-6">
            {$activityname}
        </div>
        <div class="col-lg-3">
            {$id_activitytype}
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
                {$activitysupply}
            </div>
        </div>
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


<div class="row">
    <div class="col-lg-12">
        {$btnSalvar} {$btnCancel}
    </div>
</div>
